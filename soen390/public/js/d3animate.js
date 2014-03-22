var data            = null,
    width           = $(window).width(),
    height          = $(window).height() - 225,
    visualization   = null,
    layoutGravity   = -0.01,
    damper          = 0.1,
    rectangles      = null,
    nodes           = Array(),
    force           = null,
    stdThumbW       = 75,
    stdThumbH       = 75;

var center = {
    "x": (width / 2),
    "y": (height / 2)
};

function initializeCards() {
    d3.json("/api/narrative", function(error, json) {
        if (error || json['success'] == false)
            return console.log("JSON Error Occurred: " + error);

        data = json['return'];

        createNodes();
        createVisualization();
        start();
        mainGroupFilter();
    });
}

function createNodes() {
    data.forEach(function(narrative) {
        nodes.push({
            id:        narrative.id,
            width:     stdThumbW,
            height:    stdThumbH,
            stance:    narrative.stance,
            lang:      narrative.lang,
            views:     narrative.views,
            yays:      narrative.yays,
            nays:      narrative.nays,
            mehs:      narrative.mehs,
            createdAt: narrative.createdAt,
            imageLink: narrative.images[0],
            x:         Math.random() * width,
            y:         Math.random() * height,
        });
    });
}

function cardMouseOver(eventNode) {
    rectangles
        .attr('width', function(node) {
            if (node === eventNode)
                return $(this).attr('width') * 2;
            else
                return $(this).attr('width');
        })
        .attr('height', function(node) {
            if (node === eventNode)
                return $(this).attr('height') * 2;
            else
                return $(this).attr('height');
        });

    var yays = parseInt(eventNode.yays),
        nays = parseInt(eventNode.nays),
        mehs = parseInt(eventNode.mehs);

    var totalVotes       = yays + nays + mehs,
        agreesRatio      = (yays / totalVotes) * 100,
        disagreesRatio   = (nays / totalVotes) * 100,
        indifferentRatio = (mehs / totalVotes) * 100;

    if (totalVotes == 0)
        agreesRatio = 0, disagreesRatio = 0, indifferentRatio = 0;

    $(".ratio-bar.agrees").css("width", agreesRatio + "%");
    $(".ratio-bar.disagrees").css("width", disagreesRatio + "%");

    //$("span.agrees-percent").html(agreesRatio.toPrecision(3));
    $("span.agrees-percent").html(yays);
    $("span.disagrees-percent").html(nays);
    //$("span.disagrees-percent").html(disagreesRatio.toPrecision(3));
    //$("span.indifferent-percent").html(indifferentRatio.toPrecision(3));

    $(".meta-container").css("display", "block");
    $(".meta-container").css("opacity", 1);
}

function cardMouseOut(eventNode) {
    rectangles
        .attr('width', function(node) {
            if (node === eventNode)
                return $(this).attr('width') / 2;
            else
                return $(this).attr('width');
        })
        .attr('height', function(node) {
            if (node === eventNode)
                return $(this).attr('height') / 2;
            else
                return $(this).attr('height');
        });

    $(".meta-container").css("opacity", 0);
    $(".meta-container").css("display", "block");
}

function createVisualization() {
    visualization = d3.select('#cards-container')
                      .append('svg')
                      .attr('width', width)
                      .attr('height', height)
                      .attr('id', 'svg_vis');

    rectangles = visualization.selectAll('g')
                              .data(nodes, function(node) {return node.id;});

    rectangles.enter().append("g");
  
              
    rectangles.append('image')  
            .attr("x", function (d) { return d.x })
            .attr("y", function (d) { return d.y })
            .attr("class", "child")
            .attr('data-narrative-id', function(node) {return node.id})
            .attr("width",stdThumbW)
            .attr("height",stdThumbH)
            .on('mouseover', cardMouseOver)
            .on('mouseout', cardMouseOut)  
            .attr('xlink:href', function(node) {return node.imageLink})
            .on('click', function(node) {
                 var popupWidth  = 1200, 
                    popupHeight = 665,
                    left        = (screen.width / 2) - (popupWidth / 2),
                    top         = 0,
                    windowHref  = '/player/play/' + node.id;
                    
                window.open(windowHref, 'Listen to narrative', 'toolbar=no,location=no,resizable=no,scrollbars=yes,width=' + popupWidth + ',height=' + popupHeight + ',left=' + left + ',top=' + top).focus();
             });

    rectangles.append("rect")
          .attr("x", function (d) { return d.x })
          .attr("y", function (d) { return d.y + (stdThumbH * 0.9)})
          .attr("class", "rect")
          .attr("width", function (d) {
                    var likes = parseInt(d.yays);
                    var dislikes = parseInt(d.nays);
                    var numberOfVotes = likes + dislikes;
                    var likesRatio = likes / numberOfVotes;
                    var likesRectangleWidth = (likesRatio * stdThumbW) + (dislikes / numberOfVotes) * stdThumbW;
                    return likesRectangleWidth;
                })
          .attr("height", (stdThumbH * 0.1))
          .attr("style", "fill:rgb(0,255,0);stroke-width:1;stroke:rgb(0,0,0);");

    rectangles.append("rect")
          .attr("x", function (d) { return d.x })
          .attr("y", function (d) { return d.y +(stdThumbH * 0.9)})
          .attr("class", "rect")
          .attr("width", function (d) {
                var likes = parseInt(d.yays);
                var dislikes = parseInt(d.nays);
                var numberOfVotes = likes + dislikes;
                var dislikesRatio = dislikes / numberOfVotes;
                var dislikesRectangleWidth = dislikesRatio * stdThumbW;
                return dislikesRectangleWidth;
            })
          .attr("height", (stdThumbH * 0.1))
          .attr("style", "fill:rgb(255,0,0);stroke-width:1;stroke:rgb(0,0,0)");
}

function start() {
    force = d3.layout
              .force()
              .nodes(nodes)
              .size([width, height]);
}

function mainGroupFilter() {
    force.gravity(layoutGravity)
         .charge(charge)
         .friction(0.9)
         .on('tick', function(e) {
             rectangles.selectAll(".child").each(moveTowardsCenter(e.alpha))
                            .attr('x', function(d) {return d.x})
                            .attr('y', function(d) {return d.y});

             rectangles.selectAll(".rect").each(moveTowardsCenter(e.alpha))
                          .attr('x', function(d) {return d.x})
                          .attr('y', function(d) {return d.y + (stdThumbH * 0.9)});
         });
    
    force.start();
}

function moveTowardsCenter(alpha) {
    return function(d) {
        d.x = d.x + (center.x - d.x) * (damper + 0.02) * alpha;
        d.y = d.y + (center.y - d.y) * (damper + 0.02) * alpha;
    };
}

function charge(d) {
    return -Math.pow(d.width, 2.0) / 4;
}
function calculateSize()

{

    var elementHeight = document.getElementById('svg_vis').clientHeight;

    var elementWidth = document.getElementById('svg_vis').clientWidth;


    var area = elementHeight * elementWidth;

    var numberOfCards = nodes.length;

    var cardArea = (area / 10) / (numberOfCards);


    return Math.sqrt(cardArea);

}