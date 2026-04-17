<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Activer la sécurité 2FA - ToutLike</title>
    
    <!-- Tailwind CSS for modern styling -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" xintegrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #111827;
        }
        .form-control {
            background-color: #374151;
            border: 1px solid #4b5563;
            color: #d1d5db;
            transition: all 0.3s;
        }
        .form-control:focus {
            background-color: #4b5563;
            border-color: #3b82f6;
            color: #ffffff;
            box-shadow: none;
        }
        .btn-close {
            filter: invert(1) grayscale(100%) brightness(200%);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-4xl bg-gray-800 rounded-2xl shadow-2xl overflow-hidden md:grid md:grid-cols-2">
        
        <!-- Left Side: QR Code and Instructions -->
        <div class="p-8 bg-gray-900/50">
            <h2 class="text-2xl font-bold text-white mb-2">Configurer Google Authenticator</h2>
            <p class="text-gray-400 mb-6">Scannez le code QR avec l'application Google Authenticator, ou entrez le code manuellement.</p>
            
            <!-- App Download Links -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                <a href="https://apps.apple.com/us/app/google-authenticator/id388497605" target="_blank" class="flex items-center justify-center gap-2 bg-black text-white py-2 px-4 rounded-lg hover:bg-gray-700 transition">
                    <i class="fab fa-apple"></i>
                    <div>
                        <p class="text-xs">Telecharger sur</p>
                        <p class="text-sm font-semibold">App Store</p>
                    </div>
                </a>
                <a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2" target="_blank" class="flex items-center justify-center gap-2 bg-black text-white py-2 px-4 rounded-lg hover:bg-gray-700 transition">
                    <i class="fab fa-google-play"></i>
                    <div>
                        <p class="text-xs">DISPONIBLE SUR</p>
                        <p class="text-sm font-semibold">Google Play</p>
                    </div>
                </a>
            </div>

            <div class="flex justify-center mb-6">
                <div class="bg-white p-4 rounded-lg">
                    <img src="data:image/png;base64,<?=$encoded_qr_data?>" alt="Google Authenticator Setup QR Code">
                </div>
            </div>

            <p class="text-center text-gray-400 mb-2">Ou entrez ce code manuellement :</p>
            <div class="relative bg-gray-700 text-white font-mono text-lg p-3 rounded-lg flex items-center justify-between">
                <span id="secret-key-text"><?=$GoogleTFA_admin->google2fa_secret ?></span>
                <button onclick="copyToClipboard('<?=$GoogleTFA_admin->google2fa_secret ?>', this)" class="text-gray-400 hover:text-white transition">
                    <i class="fas fa-copy"></i>
                </button>
            </div>
        </div>

        <!-- Right Side: Verification Form -->
        <div class="p-8 flex flex-col justify-center">
            <h2 class="text-2xl font-bold text-white mb-2">Verifier votre appareil</h2>
            <p class="text-gray-400 mb-6">Entrez le code a 6 chiffres de votre application d'authentification pour terminer la configuration.</p>
            
            <form action="<?=site_url("admin/activate-google-2fa")?>" method="POST" class="w-full p-0">
                <div class="error mb-4"></div>
                
                <input type="hidden" id="secret_key" name="secret_key" value="<?=$GoogleTFA_admin->google2fa_secret?>">
                
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2" for="2FA_Code">Code de verification a 6 chiffres</label>
                    <input id="2FA_Code" type="number" class="form-control w-full p-3 rounded-lg text-center text-2xl tracking-widest" name="2FA_Code" placeholder="_ _ _ _ _ _" autocomplete="off" required>
                </div>

                <div class="mt-8">
                    <button type="submit" class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-3 text-center transition">
                        Activer la verification en deux etapes
                    </button>
                    <a class="block w-full text-center mt-4 text-gray-400 hover:text-white bg-gray-700 hover:bg-gray-600 font-medium rounded-lg text-sm px-5 py-3 transition" href="<?=site_url("admin")?>">
                        Passer pour le moment
                    </a>
                </div>
            </form>
        </div>
    </div>
<script>
    // Improved copy to clipboard function with visual feedback
    function copyToClipboard(text, buttonElement) {
        if (!navigator.clipboard) {
            // Fallback for older browsers
            try {
                var textArea = document.createElement("textarea");
                textArea.value = text;
                textArea.style.top = "0";
                textArea.style.left = "0";
                textArea.style.position = "fixed";
                document.body.appendChild(textArea);
                textArea.focus();
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                showCopyFeedback(buttonElement, true);
            } catch (err) {
                console.error('Fallback: Oops, unable to copy', err);
                showCopyFeedback(buttonElement, false);
            }
            return;
        }
        navigator.clipboard.writeText(text).then(function() {
            showCopyFeedback(buttonElement, true);
        }, function(err) {
            console.error('Async: Could not copy text: ', err);
            showCopyFeedback(buttonElement, false);
        });
    }

    function showCopyFeedback(buttonElement, success) {
        const originalIcon = buttonElement.innerHTML;
        if (success) {
            buttonElement.innerHTML = `<i class="fas fa-check text-green-500"></i>`;
        } else {
            buttonElement.innerHTML = `<i class="fas fa-times text-red-500"></i>`;
        }
        setTimeout(() => {
            buttonElement.innerHTML = originalIcon;
        }, 2000);
    }

    // Original AJAX submission logic
    $(document).ready(function(){
        $("form").submit(function(e){
            e.preventDefault();
            var secret_key = $("#secret_key").val();
            var _2fa_code = $("#2FA_Code").val();
            var error = $(".error");
            
            // Basic validation
            if (_2fa_code.length !== 6) {
                error.html('<div class="p-4 mb-4 text-sm text-red-200 bg-red-900/50 rounded-lg" role="alert">Veuillez entrer un code a 6 chiffres.</div>');
                return;
            }
            
            $.ajax({
                url: "<?=site_url("admin/activate-google-2fa")?>",
                data: "secret_key=" + secret_key + "&2FA_Code=" + _2fa_code,
                type: "POST",
                success: function(response){
                    try {
                        var res = JSON.parse(response);
                        if(res.success == false){
                            // Using Bootstrap's alert structure for compatibility
                            error.html('<div class="alert alert-danger alert-dismissible fade show" role="alert"> <strong>'+res.message+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                        }
                        if(res.success == true){
                            error.html('<div class="alert alert-success alert-dismissible fade show" role="alert"> <strong>'+res.message+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                            setTimeout(() => {
                                window.location.href = "/admin";
                            }, 1500);
                        }
                    } catch(e) {
                         error.html('<div class="alert alert-danger alert-dismissible fade show" role="alert"> <strong>Une erreur inattendue s'est produite. Veuillez verifier la console.</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                         console.error("Failed to parse server response:", response);
                    }
                },
                error: function(xhr, status, err) {
                    error.html('<div class="alert alert-danger alert-dismissible fade show" role="alert"> <strong>Echec de la requete : '+status+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                    console.error("AJAX Error:", err);
                }
            });
        });
    });
</script>
</body>
</html>
