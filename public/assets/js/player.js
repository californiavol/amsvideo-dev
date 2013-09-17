/* local js */

$(document).ready(function() {
    
        jwplayer("sacstate_video").setup({
        playlist: "http://www2.csus.edu/video/assets/playlists/videos.rss",   
        height: 460,
        primary: "flash",
        width: 950,
        listbar: {
            position: "right",
            size: 360
        }
    });
});
        function GetInitialPlaylist(playlistUrl) {
            $.get(playlistUrl, function () { }, "jsonp")
            .done(function (data) {
                SetupPlayer(data.playlist);
            });
        }
        function SetupPlayer(playlist) {
               jwplayer("sacstate_video").setup({
                    playlist: playlist,   
                    height: 460,
                    primary: "flash",
                    width: 950,
                    listbar: {
                        position: "right",
                        size: 360
                    }
                });
        }
        function ChangePlaylist() {
       
            var playlist = "http://www.csus.edu/cached/Colleges/2.0/ams/assets/rss/jwplayer-rss-live.rss";
            SetupPlayer(playlist);
        }