@extends('layouts.app')
@section('content')

@section('title', 'Scan Attendance')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        body {
            background: #f5f7fb;
            font-family: Arial;
        }

        .scan-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .scan-box {
            width: 420px;
            text-align: center;
            background: #fff;
            padding: 35px;
            border-radius: 18px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.08);
            transition: 0.3s;
        }

        .scan-box:hover {
            transform: translateY(-4px);
        }

        h3 {
            margin-bottom: 10px;
        }

        input {
            width: 100%;
            padding: 14px;
            font-size: 16px;
            border-radius: 12px;
            border: 1px solid #ddd;
            margin-top: 15px;
            text-align: center;
            outline: none;
            transition: 0.2s;
        }

        input:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15);
        }

        #result {
            margin-top: 15px;
            font-weight: 600;
            color: #555;
        }

        /* ================= RESULT MODAL ================= */

        .result-modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.45);
            backdrop-filter: blur(6px);
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .result-card {
            background: #fff;
            width: 340px;
            padding: 25px;
            border-radius: 18px;
            text-align: center;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
            animation: pop 0.25s ease;
        }

        .result-img {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
            border: 3px solid #4f46e5;
        }

        #modalName {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        #modalMsg {
            color: #666;
        }

        .close-btn {
            margin-top: 15px;
            background: #4f46e5;
            color: #fff;
            border: none;
            padding: 8px 18px;
            border-radius: 10px;
            cursor: pointer;
        }

        @keyframes pop {
            from {
                transform: scale(0.8);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }
    </style>

    <div class="scan-wrapper">

        <div class="scan-box">

            <h3>📟 Scan Attendance</h3>

            <input type="text" id="scanner" placeholder="Scan code..." autocomplete="off">

            <div id="result">جاهز للـ Scan...</div>

        </div>

    </div>

    <!-- RESULT MODAL -->
    <div id="resultModal" class="result-modal">
        <div class="result-card">

            <img id="modalImg" class="result-img" />

            <h3 id="modalName"></h3>
            <p id="modalMsg"></p>

            <button onclick="closeModal()" class="close-btn">
                إغلاق
            </button>

        </div>
    </div>

    <!-- SOUNDS -->
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

            // ================= MODAL =================
            function showModal(student, message) {

                const modal = document.getElementById("resultModal");

                document.getElementById("modalName").innerText = student.name;
                document.getElementById("modalMsg").innerText = message;

                document.getElementById("modalImg").src =
                    student.photo
                        ? "/uploads/students/" + student.photo
                        : "/images/default-student.png";

                modal.style.display = "flex";

                setTimeout(() => {
                    modal.style.display = "none";
                }, 3000);
            }

            window.closeModal = function () {
                document.getElementById("resultModal").style.display = "none";
            }

            // ================= SCAN =================
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

                        if (data.student) {
                            showModal(data.student, data.message);
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
@endsection