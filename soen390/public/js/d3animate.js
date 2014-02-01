var data            = null,
    width           = $(window).width(),
    height          = $(window).height() - 200,
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
        if (error)
            return console.log("JSON Error Occurred: " + error);

        data = json;

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
            imageLink: narrative.imageLink,
            x:         Math.random() * width,
            y:         Math.random() * height,
        });
    });
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
             .attr('data-narrative-id', function(node) {return node.id})
             .attr('width', stdThumbW)
             .attr('height', stdThumbH)
             .attr('xlink:href', function(node) {return node.imageLink})
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