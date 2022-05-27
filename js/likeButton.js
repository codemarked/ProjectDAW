$(document).ready(function() {
    $("span.reaction-like").on("click", function(event){
        if (event.target.classList.contains('liked')) {
            event.target.classList.add('unliked');
            event.target.classList.remove('liked');
            event.target.style.color = "white";
            
            var postid = event.target.id.substring(2, event.target.id.length);
            
            var likeDisplay = document.getElementById("p-" + postid);
            let likes = parseInt(likeDisplay.innerHTML.substring(0,likeDisplay.innerHTML.length-6));
            likeDisplay.innerHTML = String((likes - 1) + " likes");
            
            $.post("home.php", { reaction: "Unlike_Post", postid: postid } );
        } else if (event.target.classList.contains('unliked')) {
            event.target.classList.add('liked');
            event.target.classList.remove('unliked');
            event.target.style.color = "darkred";
            
            var postid = event.target.id.substring(2, event.target.id.length);
            
            var likeDisplay = document.getElementById("p-" + postid);
            let likes = parseInt(likeDisplay.innerHTML.substring(0,likeDisplay.innerHTML.length-6));
            likeDisplay.innerHTML = String((likes + 1) + " likes");
            
            $.post("home.php", { reaction: "Like_Post", postid: postid } );
        }
    });
    $("span.reaction-comment").on("click", function(event){
        if (event.target.classList.contains('liked')) {
            event.target.classList.add('unliked');
            event.target.classList.remove('liked');
            event.target.style.color = "white";
            
            var postid = event.target.id.substring(2, event.target.id.length);
            
            var commentSection = document.getElementById("s-" + postid);
            commentSection.style.display = "none";
        } else {
            event.target.classList.add('liked');
            event.target.classList.remove('unliked');
            event.target.style.color = "darkred";
            
            var postid = event.target.id.substring(2, event.target.id.length);
            
            var commentSection = document.getElementById("s-" + postid);
            commentSection.style.display = "block";
        }
    });
});