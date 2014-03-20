var apiPath  = '',
    comments = new Array(),
    lastPost = 0;

function prepareComments(path) {
    // Set the appropriate API path
    apiPath = path;

    // Load all comments
    loadComments();

    // Register handlers
    registerCommentHandlers();
}

function loadComments() {
    // Fetch comments from the API.
    $.getJSON(apiPath, function(data) {
        var jsonReturn = data.return;

        // Hide the empty comments message if necessary.
        if (jsonReturn.length === 0) {
            $(".placeholder-comment").empty().show();
            $("<p/>").html("This narrative does not have any comments yet.").appendTo(".placeholder-comment");
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
    html += "<a href=\"#\" class=\"flag-link\" title=\"Flag spam or abusive comment.\"><i class=\"fa fa-fw fa-flag\"></i></a>";
    html += "</p>";
    html += comment.body;

    // Media footer

    html += "<div class=\"media-footer\">";

    if (comment.parent_id === null) {
        html += "<a href=\"#\" class=\"comment-reply-link\">Reply</a>&mdash;";
    }

    html += "<a href=\"#\"><i class=\"fa fa-fw fa-thumbs-up\"></i> " + comment.agrees + "</a>";
    html += "<a href=\"#\"><i class=\"fa fa-fw fa-thumbs-down\"></i> " + comment.disagrees + "</a>";
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

}

function postComment(serializedData)
{
    var secondsSinceLastPost = ((new Date()).valueOf() - lastPost) / 1000;

    if (secondsSinceLastPost < 60) {
        $(".comment-post-result").empty();
        var secondsUntilNextPost = parseInt(60 - secondsSinceLastPost);
        $.bootstrapGrowl("Please wait " + secondsUntilNextPost + " seconds before your next post.", {type: "warning"});
        return;
    }

    $.post(
        apiPath,
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