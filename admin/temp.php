<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VideoJS DASH Quality Selection</title>
    <link href="https://vjs.zencdn.net/7.20.3/video-js.css" rel="stylesheet">
    <script src="https://vjs.zencdn.net/7.20.3/video.min.js"></script>
    <script src="https://cdn.dashjs.org/latest/dash.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/videojs-contrib-dash@latest/dist/videojs-dash.min.js"></script>
</head>
<body>

    <video-js id="my_video" class="vjs-default-skin" controls preload="auto" width="640" height="360"></video-js>



    <script>
        var player = videojs('my_video');

        player.ready(function () {
            player.src({
                src: '../uploads/movies/9/video/movie/9.mpd',
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