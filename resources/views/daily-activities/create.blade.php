<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Daily Activity</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <header class="bg-blue-600 shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center">
                    <h1 class="text-3xl font-bold text-white">Create Daily Activity</h1>
                    <a href="{{ route('daily-activities.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Back to List
                    </a>
                </div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="px-4 py-6 sm:px-0">
                <div class="bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <form method="POST" action="{{ route('daily-activities.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="grid grid-cols-1 gap-6">
                                <div>
                                    <label for="zone" class="block text-sm font-medium text-gray-700">Zone</label>
                                    <input type="text" name="zone" id="zone" value="{{ old('zone') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                                    @error('zone')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="pic_name" class="block text-sm font-medium text-gray-700">PIC Name</label>
                                    <input type="text" name="pic_name" id="pic_name" value="{{ old('pic_name') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                                    @error('pic_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
                                    <input type="date" name="date" id="date" value="{{ old('date') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                                    @error('date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="abnormality" class="block text-sm font-medium text-gray-700">Abnormality</label>
                                    <select name="abnormality" id="abnormality" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                                        <option value="n" {{ old('abnormality') == 'n' ? 'selected' : '' }}>No</option>
                                        <option value="y" {{ old('abnormality') == 'y' ? 'selected' : '' }}>Yes</option>
                                    </select>
                                    @error('abnormality')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                                    
                                    <!-- Camera Section -->
                                    <div class="mt-2 mb-4">
                                        <div class="flex space-x-2 mb-2">
                                            <button type="button" id="open-camera" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-sm">
                                                📷 Open Camera
                                            </button>
                                            <button type="button" id="take-photo" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded text-sm" style="display: none;">
                                                📸 Take Photo
                                            </button>
                                            <button type="button" id="close-camera" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded text-sm" style="display: none;">
                                                ❌ Close Camera
                                            </button>
                                        </div>
                                        
                                        <div id="camera-container" style="display: none;" class="mb-2">
                                            <video id="camera-feed" autoplay playsinline class="border border-gray-300 rounded w-full max-w-md"></video>
                                            <canvas id="photo-canvas" style="display: none;" class="border border-gray-300 rounded w-full max-w-md"></canvas>
                                        </div>
                                        
                                        <div id="photo-preview" class="mb-2" style="display: none;">
                                            <p class="text-sm text-gray-600 mb-1">Captured Photo:</p>
                                            <img id="captured-image" class="border border-gray-300 rounded w-32 h-32 object-cover">
                                            <button type="button" id="retake-photo" class="ml-2 bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded text-xs">
                                                Retake
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <!-- File Upload -->
                                    <div class="mb-2">
                                        <label class="block text-sm text-gray-600 mb-1">Or upload from device:</label>
                                        <input type="file" name="image" id="image" accept="image/*" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                    
                                    <!-- Hidden input for captured photo -->
                                    <input type="hidden" name="captured_image" id="captured_image_data">
                                    
                                    @error('image')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-6">
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    Create Daily Activity
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        let stream = null;
        let capturedImageData = null;

        // Camera functionality
        document.getElementById('open-camera').addEventListener('click', async function() {
            try {
                stream = await navigator.mediaDevices.getUserMedia({ 
                    video: { 
                        facingMode: 'environment' // Use back camera on mobile
                    } 
                });
                
                const video = document.getElementById('camera-feed');
                video.srcObject = stream;
                document.getElementById('camera-container').style.display = 'block';
                document.getElementById('take-photo').style.display = 'inline-block';
                document.getElementById('close-camera').style.display = 'inline-block';
                this.style.display = 'none';
            } catch (error) {
                console.error('Error accessing camera:', error);
                alert('Unable to access camera. Please make sure you have granted camera permissions.');
            }
        });

        document.getElementById('take-photo').addEventListener('click', function() {
            const video = document.getElementById('camera-feed');
            const canvas = document.getElementById('photo-canvas');
            const ctx = canvas.getContext('2d');
            
            // Set canvas size to video size
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            
            // Draw the video frame to canvas
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
            
            // Convert to blob
            canvas.toBlob(function(blob) {
                capturedImageData = blob;
                
                // Show preview
                const img = document.getElementById('captured-image');
                img.src = canvas.toDataURL('image/jpeg');
                document.getElementById('photo-preview').style.display = 'block';
                
                // Hide camera
                document.getElementById('camera-container').style.display = 'none';
                document.getElementById('take-photo').style.display = 'none';
                document.getElementById('close-camera').style.display = 'none';
                document.getElementById('open-camera').style.display = 'inline-block';
                
                // Stop camera stream
                if (stream) {
                    stream.getTracks().forEach(track => track.stop());
                    stream = null;
                }
                
                // Clear file input
                document.getElementById('image').value = '';
            }, 'image/jpeg', 0.8);
        });

        document.getElementById('close-camera').addEventListener('click', function() {
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
                stream = null;
            }
            document.getElementById('camera-container').style.display = 'none';
            document.getElementById('take-photo').style.display = 'none';
            this.style.display = 'none';
            document.getElementById('open-camera').style.display = 'inline-block';
        });

        document.getElementById('retake-photo').addEventListener('click', function() {
            capturedImageData = null;
            document.getElementById('photo-preview').style.display = 'none';
            document.getElementById('captured_image_data').value = '';
        });

        // Handle file input change
        document.getElementById('image').addEventListener('change', function() {
            if (this.files.length > 0) {
                // Clear captured photo if file is selected
                capturedImageData = null;
                document.getElementById('photo-preview').style.display = 'none';
                document.getElementById('captured_image_data').value = '';
            }
        });

        // Before form submission, convert captured image to base64 for hidden input
        document.querySelector('form').addEventListener('submit', function(e) {
            if (capturedImageData) {
                e.preventDefault();
                const reader = new FileReader();
                reader.onload = function() {
                    document.getElementById('captured_image_data').value = reader.result;
                    e.target.submit();
                };
                reader.readAsDataURL(capturedImageData);
            }
        });
    </script>
</body>
</html>