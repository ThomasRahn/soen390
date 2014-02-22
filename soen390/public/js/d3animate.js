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

    $("span.agrees-percent").html(agreesRatio.toPrecision(3));
    $("span.disagrees-percent").html(disagreesRatio.toPrecision(3));
    $("span.indifferent-percent").html(indifferentRatio.toPrecision(3));

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

    rectangles = visualization.selectAll('image')
                              .data(nodes, function(node) {return node.id;});

    rectangles.enter()
             .append('image')
             .attr('class', 'card')
             .attr('data-narrative-id', function(node) {return node.id})
             .attr('width', stdThumbW)
             .attr('height', stdThumbH)
             .attr('xlink:href', function(node) {return node.imageLink})
             .on('mouseover', cardMouseOver)
             .on('mouseout', cardMouseOut)
             .on('click', function(node) {
                var popupWidth = screen.width * 0.75, 
                    popupHeight = screen.height * 0.75,
                    left = (screen.width / 2) - (popupWidth / 2),
                    top = (screen.height / 2) - (popupHeight / 2);
                    
                window.open('/narrative/' + node.id, 'Listen to narrative', 'toolbar=no,location=no,width=' + popupWidth + ',height=' + popupHeight + ',left=' + left + ',top=' + top).focus();
             });
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
            return rectangles.each(moveTowardsCenter(e.alpha))
                            .attr('x', function(d) {return d.x})
                            .attr('y', function(d) {return d.y});
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
    return -Math.pow(d.width, 2.0) / 8;
}
