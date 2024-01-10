function checkIfImageExists(url, callback) {
    const img = new Image();
    img.src = url;

    if (img.complete) {
        callback(true);
    } else {
        img.onload = () => {
            callback(true);
        };

        img.onerror = () => {
            callback(false);
        };
    }
}

function imgAdd() {
    checkIfImageExists(document.getElementById("imgurl").value, (exists) => {
        if (exists) {
            document.getElementById("img").value = ("[img]" + document.getElementById("imgurl").value + "[/img]");
            document.getElementById("publishimg").src = document.getElementById("imgurl").value;
        } else {
            alert("Link girmediniz ve ya girdiğiniz linke ulaşılamıyor.");
        }
    });
}

function imgRemove() {
    document.getElementById("img").value = "";
    document.getElementById("imgurl").value = "";
    document.getElementById("publishimg").src = "";
}

var lastPostID = document.getElementById("postArea").lastElementChild.getAttribute("id");
function LoadMore(sort) {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const page = parseInt(urlParams.get('p'));
    if (sort == null) {
        if (page > 0) {
            window.top.location = "/home.php?p=" + (page + 1) + "#" + lastPostID;
        } else {
            window.top.location = "/home.php?p=2" + "#" + lastPostID;
        }
    } else {
        if (page > 0) {
            window.top.location = "/home.php?p=" + (page + 1) + "&sort=" + sort + "#" + lastPostID;
        } else {
            window.top.location = "/home.php?p=2" + "&sort=" + sort + "#" + lastPostID;
        }
    }
}

function LoadMoreHashtag(tag, sort) {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const page = parseInt(urlParams.get('p'));
    if (sort == null) {
        if (page > 0) {
            window.top.location = "/hashtag.php?hashtag=" + tag + "&p=" + (page + 1) + "#" + lastPostID;
        } else {
            window.top.location = "/hashtag.php?hashtag=" + tag + "&p=2" + "#" + lastPostID;
        }
    } else {
        if (page > 0) {
            window.top.location = "/hashtag.php?hashtag=" + tag + "&sort=" + sort + "&p=" + (page + 1) + "#" + lastPostID;
        } else {
            window.top.location = "/hashtag.php?hashtag=" + tag + "&sort=" + sort + "&p=2" + "#" + lastPostID;
        }
    }
}

function LoadMoreProfile(user, sort) {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const page = parseInt(urlParams.get('p'));
    if (sort == null) {
        if (page > 0) {
            window.top.location = "/user.php?u=" + user + "&p=" + (page + 1) + "#" + lastPostID;
        } else {
            window.top.location = "/user.php?u=" + user + "&p=2" + "#" + lastPostID;
        }
    } else {
        if (page > 0) {
            window.top.location = "/user.php?u=" + user + "&sort=" + sort + "&p=" + (page + 1) + "#" + lastPostID;
        } else {
            window.top.location = "/user.php?u=" + user + "&sort=" + sort + "&p=2" + "#" + lastPostID;
        }
    }
}

function ActivePost(postid) {
    document.cookie = "activePost=" + postid;
}

function LikeButton(userid, post) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            let likecount = document.getElementById("likecount-" + post);
            let likebutton = "likebutton-" + post;
            if (this.responseText == "true") {
                document.getElementById(likebutton).classList.remove("btn-dark");
                document.getElementById(likebutton).classList.add("btn-danger");
                likecount.innerHTML = parseInt(likecount.innerHTML) + 1;
            } else if (this.responseText == "false") {
                document.getElementById(likebutton).classList.remove("btn-danger");
                document.getElementById(likebutton).classList.add("btn-dark");
                likecount.innerHTML = parseInt(likecount.innerHTML) - 1;
            } else {
                alert(this.statusText);
            }
        }
    };
    xmlhttp.open("GET", "tool_like.php?postid=" + post + "&userid=" + userid, true);
    xmlhttp.send();
}

let posts = Array.from(document.getElementsByClassName("gonderi"));
let alreadySeen = [];

window.onscroll = function () {
    if (posts != null) {
        posts.forEach(element => {
            if (checkVisible(element)) {
                if (!alreadySeen.includes(element.id)) {
                    alreadySeen.push(element.id);
                    AddSeen(element.id);
                }
            }
        });
    }
};

function checkVisible(elm) {
    var rect = elm.getBoundingClientRect();
    var viewHeight = Math.max(document.documentElement.clientHeight, window.innerHeight);
    return !(rect.bottom < 0 || rect.top - viewHeight >= 0);
}


function AddSeen(post) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", "tool_seen.php?postid=" + post, true);
    xmlhttp.send();
}
