<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotstar-style Video Player</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #000;
            font-family: 'Arial', sans-serif;
        }

        .video-container {
            position: relative;
            max-width: 100%;
            height: 100vh;
            background: #000;
            overflow: hidden;
        }

        #main-video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .video-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(180deg, rgba(0, 0, 0, 0.8) 0%, rgba(0, 0, 0, 0) 30%, rgba(0, 0, 0, 0.8) 100%);
            pointer-events: none;
            opacity: 1;
            transition: opacity 0.3s;
        }

        .video-title {
            position: absolute;
            top: 20px;
            left: 20px;
            color: #fff;
            font-size: 24px;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .controls-container {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 20px;
            background: linear-gradient(transparent, rgba(0, 0, 0, 0.7));
            opacity: 0;
            transition: opacity 0.3s;
        }

        .video-container:hover .controls-container,
        .video-container:hover .video-overlay {
            opacity: 1;
        }

        .progress-container {
            position: relative;
            height: 5px;
            background: rgba(255, 255, 255, 0.1);
            /* Dark background */
            margin-bottom: 15px;
            cursor: pointer;
            border-radius: 3px;
        }

        .buffered-bar {
            position: absolute;
            height: 100%;
            background: rgba(255, 255, 255, 0.3);
            /* Light white buffered progress */
            width: 0;
            border-radius: 3px;
            transition: width 0.3s ease;
            z-index: 1;
        }

        .progress-bar {
            height: 100%;
            background: #e50914;
            /* Red played progress */
            position: relative;
            transition: width 0.1s linear;
            border-radius: 3px;
            z-index: 2;
        }

        .controls-bottom {
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: #fff;
        }

        .controls-left,
        .controls-right {
            display: flex;
            align-items: center;
            gap: 25px;
        }

        .control-btn {
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .control-btn:hover {
            transform: scale(1.1);
            color: #e50914;
        }

        .settings-menu {
            position: absolute;
            bottom: 60px;
            right: 20px;
            background: rgba(0, 0, 0, 0.8);
            padding: 10px;
            border-radius: 4px;
            display: none;
        }

        .settings-item {
            color: #fff;
            padding: 8px 15px;
            cursor: pointer;
            white-space: nowrap;
        }

        .settings-item:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .loading-spinner {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            display: none;
        }

        .big-play-btn {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 4rem;
            color: rgba(255, 255, 255, 0.9);
            cursor: pointer;
            transition: transform 0.2s;
        }

        .big-play-btn:hover {
            transform: translate(-50%, -50%) scale(1.1);
        }

        .quality-indicator {
            position: absolute;
            top: 20px;
            right: 20px;
            background: rgba(0, 0, 0, 0.7);
            color: #fff;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.8rem;
        }


        .volume-container {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 120px;
            transition: width 0.3s ease;
            position: relative;
        }

        .volume-slider {
            width: 0;
            opacity: 0;
            transition: width 0.3s ease, opacity 0.3s ease;
            height: 4px;
            background: transparent;
            border-radius: 2px;
            appearance: none;
            cursor: pointer;
            position: relative;
        }

        /* Webkit Track */
        .volume-slider::-webkit-slider-runnable-track {
            width: 100%;
            height: 4px;
            background: rgba(255, 255, 255, 0.3);
            /* Gray background */
            border-radius: 2px;
        }

        /* Webkit Progress */
        .volume-slider::-webkit-slider-thumb {
            position: relative;
            z-index: 2;
        }

        .volume-slider::before {
            content: '';
            position: absolute;
            left: 0;
            height: 4px;
            background: #e50914;
            /* Red progress */
            width: var(--progress, 100%);
            border-radius: 2px;
            pointer-events: none;
            z-index: 1;
        }

        /* Firefox Track */
        .volume-slider::-moz-range-track {
            width: 100%;
            height: 4px;
            background: rgba(255, 255, 255, 0.3);
            /* Gray background */
            border-radius: 2px;
        }

        /* Firefox Progress */
        .volume-slider::-moz-range-progress {
            background: #e50914;
            /* Red progress */
            height: 4px;
            border-radius: 2px;
        }

        /* Thumb Styles */
        .volume-slider::-webkit-slider-thumb {
            appearance: none;
            width: 12px;
            height: 12px;
            background: #e50914;
            border-radius: 50%;
            cursor: pointer;
            margin-top: -4px;
            transition: transform 0.2s;
        }

        .volume-slider::-moz-range-thumb {
            width: 12px;
            height: 12px;
            background: #e50914;
            border-radius: 50%;
            cursor: pointer;
            border: none;
        }

        .volume-slider::-webkit-slider-thumb:hover {
            transform: scale(1.2);
        }

        .volume-container:hover .volume-slider {
            width: 100px;
            opacity: 1;
        }


        /* Buffered Progress */
        .buffered-bar {
            position: absolute;
            height: 100%;
            background: rgba(255, 255, 255, 0.1);
            width: 0;
        }

        /* Skip Animation */
        .skip-animation {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 2rem;
            color: white;
            background: rgba(0, 0, 0, 0.7);
            padding: 15px 20px;
            border-radius: 50%;
            display: none;
            animation: skipFade 1s ease-out;
        }

        @keyframes skipFade {
            0% {
                opacity: 1;
                transform: translate(-50%, -50%) scale(1);
            }

            100% {
                opacity: 0;
                transform: translate(-50%, -50%) scale(2);
            }
        }

        /* Time Transition */
        .time-display {
            transition: all 0.3s ease;
        }

        .time-update {
            transform: scale(1.2);
            color: #e50914;
        }

        .volume-container:hover .volume-slider {
            width: 100px !important;
            opacity: 1 !important;
        }
    </style>
    <link href="https://vjs.zencdn.net/7.20.3/video-js.css" rel="stylesheet">
    <script src="https://vjs.zencdn.net/7.20.3/video.min.js"></script>
    <script src="https://cdn.dashjs.org/latest/dash.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/videojs-contrib-dash@latest/dist/videojs-dash.min.js"></script>
    <style>
     .ms-1{
        margin-left: 10px;
     }
    </style>
</head>

<body>
    <div class="video-container">
        <video id="main-video" preload="auto" style="height: 100%; width: 100%;"></video>


        <div class="buffered-bar"></div>
        <div class="skip-animation" id="skip-back">5<i class="fas fa-backward ms-1"></i></div>
        <div class="skip-animation" id="skip-forward">5<i class="fas fa-forward ms-1"></i></div>

        <div class="video-overlay">
            <div class="video-title">Big Buck Bunny</div>
            <div class="quality-indicator">HD</div>
            <div class="big-play-btn"><i class="fas fa-play"></i></div>
        </div>

        <div class="preview-thumbnail"></div>
        <div class="preview-time">0:00</div>

        <div class="controls-container">
            <div class="progress-container">
                <div class="buffered-bar"></div>
                <div class="progress-bar">
                    <div class="seek-thumb"></div>
                </div>
            </div>
            <div class="controls-bottom">
                <div class="controls-left">
                    <button class="control-btn" id="play-pause"><i class="fas fa-play"></i></button>
                    <button class="control-btn" id="volume-btn"><i class="fas fa-volume-up"></i></button>
                    <input type="range" class="volume-slider" min="0" max="1" step="0.1" value="1">
                    <span class="time-display">
                        <span id="current-time">0:00</span> /
                        <span id="duration">0:00</span>
                    </span>
                </div>
                <div class="controls-right">
                    <button class="control-btn" id="settings-btn"><i class="fas fa-cog"></i></button>
                    <button class="control-btn" id="fullscreen"><i class="fas fa-expand"></i></button>
                </div>
            </div>
        </div>

        <div class="settings-menu" id="settings-menu">
            <div class="settings-item" data-speed="1">Speed: 1x</div>
            <div class="settings-item" data-speed="1.5">Speed: 1.5x</div>
            <div class="settings-item" data-speed="2">Speed: 2x</div>
            <div class="settings-divider"></div>
            <div class="settings-item" data-quality="hd">Quality: HD</div>
            <div class="settings-item" data-quality="sd">Quality: SD</div>
        </div>


        <div class="loading-spinner"><i class="fas fa-spinner fa-spin"></i></div>
    </div>

    <script>
        const video = document.getElementById('main-video');
        const playPauseBtn = document.getElementById('play-pause');
        const progressBar = document.querySelector('.progress-bar');
        const progressContainer = document.querySelector('.progress-container');
        const volumeSlider = document.querySelector('.volume-slider');
        const volumeBtn = document.getElementById('volume-btn');
        const fullscreenBtn = document.getElementById('fullscreen');
        const currentTimeDisplay = document.getElementById('current-time');
        const durationDisplay = document.getElementById('duration');
        const settingsBtn = document.getElementById('settings-btn');
        const settingsMenu = document.getElementById('settings-menu');
        const bigPlayBtn = document.querySelector('.big-play-btn');
        const videoOverlay = document.querySelector('.video-overlay');
        const previewThumbnail = document.querySelector('.preview-thumbnail');
        const previewTime = document.querySelector('.preview-time');
        const loadingSpinner = document.querySelector('.loading-spinner');
        const qualityIndicator = document.querySelector('.quality-indicator');

        let isDraggingProgress = false;
        let controlsTimeout;
        let isSettingsOpen = false;

        // Play/Pause controls
        function togglePlay() {
            if (video.paused) {
                video.play();
                playPauseBtn.innerHTML = '<i class="fas fa-pause"></i>';
                bigPlayBtn.style.display = 'none';
                videoOverlay.style.opacity = '0';
            } else {
                video.pause();
                playPauseBtn.innerHTML = '<i class="fas fa-play"></i>';
                bigPlayBtn.style.display = 'block';
                videoOverlay.style.opacity = '1';
            }
        }

        playPauseBtn.addEventListener('click', togglePlay);
        bigPlayBtn.addEventListener('click', togglePlay);
        video.addEventListener('click', togglePlay);

        // Progress bar with preview
        progressContainer.addEventListener('mousemove', (e) => {
            const rect = progressContainer.getBoundingClientRect();
            const percent = (e.clientX - rect.left) / rect.width;
            const previewTimeValue = percent * video.duration;

            previewTime.textContent = formatTime(previewTimeValue);
            previewTime.style.left = `${e.clientX - rect.left}px`;
            previewTime.style.display = 'block';

            // For actual implementation, you would load thumbnail based on time
            previewThumbnail.style.left = `${e.clientX}px`;
            previewThumbnail.style.display = 'block';
        });

        progressContainer.addEventListener('mouseleave', () => {
            previewThumbnail.style.display = 'none';
            previewTime.style.display = 'none';
        });

        // Settings menu
        settingsBtn.addEventListener('click', () => {
            isSettingsOpen = !isSettingsOpen;
            settingsMenu.style.display = isSettingsOpen ? 'block' : 'none';
        });

        document.querySelectorAll('.settings-item').forEach(item => {
            item.addEventListener('click', (e) => {
                if (e.target.dataset.speed) {
                    video.playbackRate = parseFloat(e.target.dataset.speed);
                }
                if (e.target.dataset.quality) {
                    qualityIndicator.textContent = e.target.dataset.quality.toUpperCase();
                }
                settingsMenu.style.display = 'none';
                isSettingsOpen = false;
            });
        });

        // Video loading state
        video.addEventListener('waiting', () => {
            loadingSpinner.style.display = 'block';
        });

        video.addEventListener('playing', () => {
            loadingSpinner.style.display = 'none';
        });

        // Fullscreen handling
        function toggleFullscreen() {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen();
                fullscreenBtn.innerHTML = '<i class="fas fa-compress"></i>';
            } else {
                document.exitFullscreen();
                fullscreenBtn.innerHTML = '<i class="fas fa-expand"></i>';
            }
        }

        // Keyboard shortcuts
        document.addEventListener('keydown', (e) => {
            switch (e.key.toLowerCase()) {
                case ' ':
                    e.preventDefault();
                    togglePlay();
                    break;
                case 'k':
                    e.preventDefault();
                    togglePlay();
                    break;
                case 'arrowleft':
                    video.currentTime -= 5;
                    break;
                case 'arrowright':
                    video.currentTime += 5;
                    break;
                case 'm':
                    video.muted = !video.muted;
                    break;
                case 'f':
                    toggleFullscreen();
                    break;
                case 'escape':
                    if (document.fullscreenElement) {
                        toggleFullscreen();
                    }
                    break;
            }
        });

        // Rest of the functionality (volume, time updates, etc.) similar to previous example
        // Add those event listeners and functions from previous implementation here

        // Initialize video
        video.addEventListener('loadedmetadata', () => {
            durationDisplay.textContent = formatTime(video.duration);
        });



        // function formatTime(time) {
        //     const hours = Math.floor(time / 3600);
        //     const minutes = Math.floor((time % 3600) / 60);

        //     if (hours > 0) {
        //         return `${hours}:${minutes.toString().padStart(2, '0')}`;
        //     }
        //     return `00:${minutes}`;
        // }

        function formatTime(time) {
    const hours = Math.floor(time / 3600);
    const minutes = Math.floor((time % 3600) / 60);
    const seconds = Math.floor(time % 60); // Ensuring an integer value

    return `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
}

        // Auto-hide controls
        document.addEventListener('mousemove', () => {
            controlsContainer.style.opacity = '1';
            clearTimeout(controlsTimeout);
            controlsTimeout = setTimeout(() => {
                if (!video.paused) {
                    controlsContainer.style.opacity = '0';
                    videoOverlay.style.opacity = '0';
                }
            }, 2000);
        });
    </script>
    <script>
        // Volume Controls
        let lastVolume = 1;

        volumeSlider.addEventListener('input', (e) => {
            video.volume = e.target.value;
            video.muted = false;
            volumeBtn.innerHTML = video.volume === 0 ?
                '<i class="fas fa-volume-mute"></i>' :
                '<i class="fas fa-volume-up"></i>';
        });

        volumeBtn.addEventListener('click', () => {
            video.muted = !video.muted;
            if (video.muted) {
                lastVolume = video.volume;
                video.volume = 0;
                volumeSlider.value = 0;
            } else {
                video.volume = lastVolume;
                volumeSlider.value = lastVolume;
            }
            volumeBtn.innerHTML = video.muted ?
                '<i class="fas fa-volume-mute"></i>' :
                '<i class="fas fa-volume-up"></i>';
        });

        // Buffered Progress
        video.addEventListener('progress', () => {
            const buffered = video.buffered;
            if (buffered.length > 0) {
                const bufferedEnd = buffered.end(buffered.length - 1);
                const bufferedWidth = (bufferedEnd / video.duration) * 100;
                document.querySelector('.buffered-bar').style.width = `${bufferedWidth}%`;
            }
        });

        // Skip Animation
        function showSkipAnimation(direction) {
            const skipElement = direction === 'forward' ?
                document.getElementById('skip-forward') :
                document.getElementById('skip-back');

            skipElement.style.display = 'block';
            skipElement.style.animation = 'none';
            void skipElement.offsetHeight; // Trigger reflow
            skipElement.style.animation = 'skipFade 1s ease-out';

            setTimeout(() => {
                skipElement.style.display = 'none';
            }, 1000);

            // Time display animation
            currentTimeDisplay.classList.add('time-update');
            setTimeout(() => {
                currentTimeDisplay.classList.remove('time-update');
            }, 300);
        }

        // Updated Keyboard Shortcuts with Animation
        document.addEventListener('keydown', (e) => {
            switch (e.key.toLowerCase()) {
                case 'arrowleft':
                    video.currentTime -= 5;
                    showSkipAnimation('back');
                    break;
                case 'arrowright':
                    video.currentTime += 5;
                    showSkipAnimation('forward');
                    break;
                // Keep existing cases
            }
        });

        // Precise Preview Thumbnail Positioning
        progressContainer.addEventListener('mousemove', (e) => {
            const rect = progressContainer.getBoundingClientRect();
            const percent = Math.min(Math.max((e.clientX - rect.left) / rect.width, 0), 1);
            const previewTimeValue = percent * video.duration;

            previewTime.textContent = formatTime(previewTimeValue);
            previewTime.style.left = `${percent * 100}%`;
            previewThumbnail.style.left = `${e.clientX}px`;
        });

        // Click to Seek with Animation
        progressContainer.addEventListener('click', (e) => {
            const rect = progressContainer.getBoundingClientRect();
            const percent = (e.clientX - rect.left) / rect.width;
            video.currentTime = percent * video.duration;
            showSkipAnimation(percent > video.currentTime / video.duration ? 'forward' : 'back');
        });
    </script>
    <script>
        // Add these updates to the JavaScript section

        // Initialize video
        video.addEventListener('loadedmetadata', () => {
            durationDisplay.textContent = formatTime(video.duration);
        });

        // Dynamic time update
        video.addEventListener('timeupdate', updateProgress);

        function updateProgress() {
            const progress = (video.currentTime / video.duration) * 100;
            progressBar.style.width = `${progress}%`;
            currentTimeDisplay.textContent = formatTime(video.currentTime);
        }

        // Proper seek functionality
        progressContainer.addEventListener('click', (e) => {
            const rect = progressContainer.getBoundingClientRect();
            const pos = (e.clientX - rect.left) / rect.width;
            video.currentTime = pos * video.duration;
        });

        // Drag handling for progress bar
        progressContainer.addEventListener('mousedown', startDragging);
        document.addEventListener('mousemove', whileDragging);
        document.addEventListener('mouseup', stopDragging);

        function startDragging(e) {
            isDraggingProgress = true;
            const rect = progressContainer.getBoundingClientRect();
            const pos = (e.clientX - rect.left) / rect.width;
            video.currentTime = pos * video.duration;
        }

        function whileDragging(e) {
            if (!isDraggingProgress) return;
            const rect = progressContainer.getBoundingClientRect();
            const pos = (e.clientX - rect.left) / rect.width;
            video.currentTime = pos * video.duration;
        }

        function stopDragging() {
            isDraggingProgress = false;
        }

        // Add this to the existing keyboard shortcuts handler
        document.addEventListener('keydown', (e) => {
            switch (e.key.toLowerCase()) {
                case 'arrowleft':
                    video.currentTime -= 5;
                    showSkipAnimation('back');
                    break;
                case 'arrowright':
                    video.currentTime += 5;
                    showSkipAnimation('forward');
                    break;
                // Keep other cases the same
            }
        });

        // Update the progress bar preview
        progressContainer.addEventListener('mousemove', (e) => {
            const rect = progressContainer.getBoundingClientRect();
            const percent = Math.min(Math.max((e.clientX - rect.left) / rect.width, 0), 1);
            const previewTimeValue = percent * video.duration;

            previewTime.textContent = formatTime(previewTimeValue);
            previewTime.style.left = `${percent * 100}%`;
            previewThumbnail.style.left = `${e.clientX}px`;
        });
    </script>
    <script>
        // Update these parts in your JavaScript

        // Auto-hide controls

        let controlsContainer = document.getElementsByClassName("controls-container")[0];

        function resetControlsTimer() {
            // Always show controls when interacting
            controlsContainer.style.opacity = '1';
            videoOverlay.style.opacity = '1';
            clearTimeout(controlsTimeout);

            // Hide after 3 seconds if video is playing
            if (!video.paused) {
                controlsTimeout = setTimeout(() => {
                    controlsContainer.style.opacity = '0';
                    videoOverlay.style.opacity = '0';
                }, 3000);
            }
        }

        // Add event listeners for user activity
        document.addEventListener('mousemove', resetControlsTimer);
        document.addEventListener('click', resetControlsTimer);
        document.addEventListener('keypress', resetControlsTimer);

        // Initialize timer when video starts
        video.addEventListener('play', resetControlsTimer);

        // Volume Controls Fix
        const volumeContainer = document.querySelector('.video-container');

        // Show/hide volume slider on hover
        volumeContainer.addEventListener('mouseenter', () => {
            volumeSlider.style.width = '100px';
            volumeSlider.style.opacity = '1';
        });

        volumeContainer.addEventListener('mouseleave', () => {
            if (!video.muted) {
                volumeSlider.style.width = '0';
                volumeSlider.style.opacity = '0';
            }
        });

        // Update volume slider visibility when muted
        volumeBtn.addEventListener('click', () => {
            if (video.muted) {
                volumeSlider.style.width = '100px';
                volumeSlider.style.opacity = '1';
            } else {
                volumeSlider.style.width = '0';
                volumeSlider.style.opacity = '0';
            }
        });

        // Proper volume slider functionality
        volumeSlider.addEventListener('input', (e) => {
            video.volume = e.target.value;
            video.muted = false;
            volumeBtn.innerHTML = '<i class="fas fa-volume-up"></i>';
            if (video.volume === 0) {
                video.muted = true;
                volumeBtn.innerHTML = '<i class="fas fa-volume-mute"></i>';
            }
        });

        // Initialize volume slider position
        volumeSlider.value = video.volume;
    </script>
    <script>
        // Update volume progress
        function updateVolumeProgress() {
            const progress = (video.volume * 100) + '%';
            document.querySelectorAll('.volume-slider').forEach(slider => {
                slider.style.setProperty('--progress', progress);
            });
        }

        volumeSlider.addEventListener('input', () => {
            updateVolumeProgress();
        });

        // Initialize volume progress
        updateVolumeProgress();

        // Update buffered progress
        function updateBufferedProgress() {
            if (video.buffered.length > 0) {
                const bufferedEnd = video.buffered.end(video.buffered.length - 1);
                const bufferedWidth = (bufferedEnd / video.duration) * 100;
                document.querySelector('.buffered-bar').style.width = `${bufferedWidth}%`;
            }
        }

        // Add event listeners
        video.addEventListener('progress', updateBufferedProgress);
        video.addEventListener('timeupdate', updateBufferedProgress);
    </script>
    <script>
        var player = videojs('main-video');

        player.ready(function () {
            player.src({
                src: '../uploads/movies/27/video/movie/27.mpd',
                type: 'application/dash+xml'
            });

            player.on('loadedmetadata', function () {
                if (player.dash) {
                    window.dashPlayer = player.dash.mediaPlayer; // Correct way to get DASH.js instance
                    console.log('DASH.js instance ready:', window.dashPlayer);
                } else {
                    console.log('DASH.js instance not found');
                }
            });
        });

        function setQuality(index) {
            if (window.dashPlayer) {
                if (index === 'auto') {
                    window.dashPlayer.updateSettings({
                        streaming: { abr: { autoSwitchBitrate: { video: true } } }
                    });
                    console.log('Auto quality enabled');
                } else {
                    window.dashPlayer.updateSettings({
                        streaming: { abr: { autoSwitchBitrate: { video: false } } }
                    });
                    window.dashPlayer.setQualityFor('video', index);
                    console.log('Manual quality set to:', index);
                }
            } else {
                console.log('DASH.js instance not available yet');
            }
        }
    </script>
</body>
</html>