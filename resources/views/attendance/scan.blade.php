<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    body {
        background: #f5f7fb;
        font-family: Arial;
    }

    .scan-box {
        width: 400px;
        margin: 100px auto;
        text-align: center;
        background: #fff;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    input {
        width: 100%;
        padding: 12px;
        font-size: 16px;
        border-radius: 10px;
        border: 1px solid #ddd;
        margin-top: 15px;
        text-align: center;
    }

    #result {
        margin-top: 15px;
        font-weight: bold;
    }

    #popup {
        display: none;
        position: fixed;
        top: 20px;
        right: 20px;
        background: #fff;
        padding: 15px;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        align-items: center;
        gap: 10px;
        z-index: 9999;
    }

    #popup img {
        width: 60px;
        height: 60px;
        border-radius: 50%;
    }
</style>

<div class="scan-box">

    <h3>📟 Scan Attendance</h3>

    <input type="text" id="scanner" placeholder="Scan code..." autocomplete="off">

    <div id="result">Enter code</div>

</div>

<!-- popup -->
<div id="popup">
    <img id="popupImg">
    <div>
        <div id="popupName"></div>
        <div id="popupMsg"></div>
    </div>
</div>

<audio id="sound-in" src="{{ asset('sounds/check-in.mp3') }}"></audio>
<audio id="sound-out" src="{{ asset('sounds/check-out.mp3') }}"></audio>
<audio id="sound-error" src="{{ asset('sounds/error.mp3') }}"></audio>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        const input = document.getElementById('scanner');
        const result = document.getElementById('result');

        const soundIn = document.getElementById('sound-in');
        const soundOut = document.getElementById('sound-out');
        const soundError = document.getElementById('sound-error');

        let locked = false;

        input.focus();

        function scan(code) {

            if (!code || locked) return;

            locked = true;

            fetch("/scan", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name=csrf-token]').content
                },
                body: JSON.stringify({ code })
            })
                .then(res => res.json())
                .then(data => {

                    result.innerText = data.message;

                    if (data.type === "checkin") soundIn.play();
                    else if (data.type === "checkout") soundOut.play();
                    else soundError.play();

                    // popup
                    if (data.student) {
                        const popup = document.getElementById("popup");
                        const popupImg = document.getElementById("popupImg");
                        const popupName = document.getElementById("popupName");
                        const popupMsg = document.getElementById("popupMsg");

                        popup.style.display = "flex";

                        popupName.innerText = data.student.name;
                        popupMsg.innerText = data.message;

                        popupImg.src = data.student.photo
                            ? "/uploads/students/" + data.student.photo
                            : "/images/default-student.png";

                        setTimeout(() => popup.style.display = "none", 2500);
                    }

                })
                .catch(() => {
                    soundError.play();
                    result.innerText = "❌ Error";
                })
                .finally(() => {
                    input.value = "";
                    input.focus();
                    locked = false;
                });
        }

        input.addEventListener('keydown', function (e) {
            if (e.key === "Enter") {
                scan(input.value.trim());
            }
        });

    });
</script>