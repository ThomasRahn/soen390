var commentApiPath = '',
    comments       = new Array(),
    lastPost       = 0;

function prepareComments(path) {
    // Set the appropriate API path
    commentApiPath = path;

    // Load all comments
    loadComments();

    // Register handlers
    registerCommentHandlers();
}

function loadComments() {
    // Fetch comments from the API.
    $.getJSON(commentApiPath, function(data) {
        var jsonReturn = data.return;

        // Hide the empty comments message if necessary.
        if (jsonReturn.length === 0) {
            $(".placeholder-comment").empty().show();
            $("<p/>").html("This narrative does not have any comments yet. / Ce r&eacute;cit a pas du commentaire.").appendTo(".placeholder-comment");
            return;
        } else {
            $(".placeholder-comment").hide();
        }

        var listItems = new Array();

        $.each(jsonReturn, function(index, c) {
            comments[parseInt(c.comment_id)] = c;
            listItems.push(generateCommentMediaObject(c));
        });

        var elements = $("<ul/>", { html: listItems.join("") }).addClass("media-list");

        $(".comment-frame").html(elements);

        $("a").tooltip();

        registerCommentHandlers();
    });
}

function generateCommentMediaObject(comment) {
    var html     = "",
        children = comment.children;

    html += "<div class=\"media\" data-comment-id=\"" + comment.comment_id + "\">";
    html += "<div class=\"media-body\">";
    html += "<p class=\"media-heading\">"
    html += comment.name + "<small>" + comment.created_at + "</small>";

    if(comment.deleted == 0){

     html += "<a href=\"#\" class=\"flag-link";

        if (sessionStorage.commentFlags) {
            var flags = JSON.parse(sessionStorage.commentFlags);

            if (flags[comment.comment_id] === true) {
                html += " flagged";
            }
        }
    
        html += "\" title=\"Flag spam or abusive comment.\"><i class=\"fa fa-fw fa-flag\"></i></a>";
    }
    html += "</p>";
    html += comment.body;

    // Media footer

    html += "<div class=\"media-footer\">";

    if (comment.parent_id === null && comment.deleted == 0) {
        html += "<a href=\"#\" class=\"comment-reply-link\" title=\"Reply to this comment?\">Reply</a>&mdash;";
    }

    var votedAgrees = null;

    if (sessionStorage.commentVote) {
        votedAgrees = (JSON.parse(sessionStorage.commentVote))[comment.comment_id];
    }

    if(comment.deleted == 0) {
        html += "<a href=\"#\" class=\"comment-agree-link" + (votedAgrees === true ? " voted" : "");
        html += "\" title=\"Agree with this comment?\"><i class=\"fa fa-fw fa-thumbs-up\"></i> " + comment.agrees + "</a>";
        html += "<a href=\"#\" class=\"comment-disagree-link" + (votedAgrees === false ? " voted" : "");
        html += "\" title=\"Disagree with this comment?\"><i class=\"fa fa-fw fa-thumbs-down\"></i> " + comment.disagrees + "</a>";
    }
    html += "</div>";
    // Child comments

    $.each(children, function(index, c) {
        html += generateCommentMediaObject(c);
    });

    html += "</div>";
    html += "</div>";

    return html;
}

function registerCommentHandlers() {

    // Unbind handlers first
    $(".comment-form").unbind();
    $(".comment-reply-link").unbind();
    $("#subcomment-form").unbind();
    $(".comment-agree-link").unbind();
    $(".comment-disagree-link").unbind();
    $(".flag-link").unbind();
    $("#comment-report-form").unbind();

    $(".comment-form").bind("submit", function(e) {
        e.preventDefault();

        $("<i/>").addClass("fa fa-spin fa-spinner").appendTo(".comment-post-result");

        postComment($(".comment-form").serialize());
    });

    $(".comment-reply-link").bind("click", function(e) {
        e.preventDefault();

        var id      = $(this).parent().parent().parent().data("comment-id"),
            comment = comments[parseInt(id)];

        console.log("parent id = " + id);

        $(".parent-comment-body").html(comment.body);
        $(".parent-comment-name cite").attr("title", comment.created_at);
        $(".parent-comment-name cite").html(comment.name);
        $("#subcomment-form input[name=parent]").val(comment.comment_id);

        $("#subcomment-modal").modal("show");
    });

    $("#subcomment-form").bind("submit", function(e) {
        e.preventDefault();

        console.log("subcomment-form submit");

        postComment($("#subcomment-form").serialize());
    });

    $(".comment-agree-link").click(function(e) {
        e.preventDefault();

        var id = $(this).parent().parent().parent().data("comment-id");

        postVote(id, true);
    });

    $(".comment-disagree-link").click(function(e) {
        e.preventDefault();

        var id = $(this).parent().parent().parent().data("comment-id");

        postVote(id, false);
    });

    $(".flag-link").click(function(e) {
        e.preventDefault();

        var id = $(this).parent().parent().parent().data("comment-id");

        $("#report-comment-id").val(id);

        $("#report-comment-modal").modal("show");
    });

    $("#comment-report-form").bind("submit", function(e) {
        e.preventDefault();

        var id = $("#report-comment-id").val();

        postFlag(id, $("#comment-report-form").serialize());
    });

}

function postComment(serializedData) {
    var secondsSinceLastPost = ((new Date()).valueOf() - lastPost) / 1000;

    if (secondsSinceLastPost < 60) {
        $(".comment-post-result").empty();
        var secondsUntilNextPost = parseInt(60 - secondsSinceLastPost);
        $.bootstrapGrowl("Please wait " + secondsUntilNextPost + " seconds before your next post.", {type: "warning"});
        return;
    }

    $.post(
        commentApiPath,
        serializedData
    ).done(function(data, status, xhr) {
        $.bootstrapGrowl("Comment posted!", {type: "success"});
        lastPost = new Date();
        $(".comment-form")[0].reset();
        $("#subcomment-form")[0].reset();
        $("#subcomment-modal").modal("hide");
        loadComments();
    }).fail(function(xhr, status, error) {
        $.bootstrapGrowl("An error occured while posting comment. Please try again later.", {type: "danger"});
        console.log(xhr.responseText);
    }).always(function() {
        $(".comment-post-result").empty();
    });
}

function postVote(id, agree) {
    if (sessionStorage.commentVote === undefined) {
        sessionStorage.commentVote = JSON.stringify(new Array());
    }

    var postObj = { "agree": agree };

    var existingVotes = JSON.parse(sessionStorage.commentVote);

    console.log(JSON.stringify(existingVotes[id]));

    if (existingVotes[id] !== null && existingVotes[id] !== undefined) {
        if (existingVotes[id] === agree) {
            return;
        } else {
            postObj["swap"] = true;
        }
    }

    console.log("posting = " + JSON.stringify(postObj));

    $.post(
        "/api/comment/vote/" + id,
        postObj
    ).done(function(data, status, xhr) {
        $.bootstrapGrowl("Voted!", { type: "success" });

        existingVotes[id] = agree;
        sessionStorage.commentVote = JSON.stringify(existingVotes);

        loadComments();
    }).fail(function(xhr, status, error) {
        $.bootstrapGrowl("An error occurred while storing the vote. Please try again later.", { type: "danger" });
        console.log(xhr.responseText);
    });
}

function postFlag(id, serializedData) {
    if (sessionStorage.commentFlags === undefined) {
        sessionStorage.commentFlags = JSON.stringify(new Array());
    }

    $.post(
        "/api/comment/flag/" + id,
        serializedData
    ).done(function(data, status, xhr) {
        $.bootstrapGrowl("Flagged!", { type: "success" });

        $("#comment-report-form")[0].reset();
        $("#report-comment-modal").modal("hide");

        var flags = JSON.parse(sessionStorage.commentFlags);
        flags[id] = true;
        sessionStorage.commentFlags = JSON.stringify(flags);

        loadComments();

    }).fail(function(xhr, status, error) {
        $.bootstrapGrowl("An error occurred while storing the report. Please try again later.", { type: "danger" });
        console.log(xhr.responseText);
    });
}