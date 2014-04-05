var data            = null,
    width           = $(window).width(),
    height          = $(window).height() - 235,
    visualization   = null,
    layoutGravity   = -0.01,
    damper          = 0.1,
    rectangles      = null,
    nodes           = new Array(),
    force           = null,
    stdThumbW       = 75,
    stdThumbH       = 75,
    stdRectH        = 7.5,
    viewFilter      = false,
    increamentValue = 0.7,
    totalViews      = 0,
    numberOfNarr    = 0,
    z               = 0,
    testValue       = 1,
    minWidth        = 37;

var narrative_ids = [];

var center =
{
    "x": (width / 2),
    "y": (height / 2)
};

function initializeCards()
{
     d3.json("/api/narrative", function(error, json)
    {
        if (error || json['success'] == false)
            return console.log("JSON Error Occurred: " + error);

        data = json['return'];
        stdThumbH = calculateSize();
        stdThumbW = calculateSize();
        createNodes();
        createVisualization();
        start();
        mainGroupFilter();
    });
}

function createNodes()
{
    data.forEach(function(narrative)
    {
        totalViews += parseInt(narrative.views);
        numberOfNarr += 1;
        nodes.push(
        {
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
            x:         height / 2,
            y:         width / 2,
            centerX:   (stdThumbW / 2),
            centerY:   (stdThumbH / 2),
            radius:    Math.sqrt(Math.pow(stdThumbW / 2, 2) + Math.pow(stdThumbH / 2, 2))
        });
    });

    z = totalViews / data.length;
}

function cardMouseOver(eventNode)
{
    var yays = parseInt(eventNode.yays),
        nays = parseInt(eventNode.nays),
        mehs = parseInt(eventNode.mehs);
    
    rectangles.selectAll(".child").style("cursor",function(node){
        if (node.id == eventNode.id){
            return "pointer";
        }else{
            return "default";
        }
     });
        
    var totalVotes       = yays + nays + mehs,
    agreesRatio      = (yays / totalVotes) * 100,
    disagreesRatio   = (nays / totalVotes) * 100,
    indifferentRatio = (mehs / totalVotes) * 100;

    if (totalVotes == 0)
    {
        agreesRatio = 0, disagreesRatio = 0, indifferentRatio = 0;
    }

    $(".ratio-bar.agrees").css("width", agreesRatio + "%");
    $(".ratio-bar.disagrees").css("width", disagreesRatio + "%");

    $("span.agrees-percent").html(yays);
    $("span.disagrees-percent").html(nays);

    $(".meta-container").css("display", "block");
    $(".meta-container").css("opacity", 1);
}

function cardMouseOut(eventNode)
{
    $(".meta-container").css("opacity", 0);
    $(".meta-container").css("display", "block");
}

function createVisualization()
{
    visualization = d3.select('#cards-container')
                      .append('svg')
                      .attr('width', width)
                      .attr('height', height)
                      .attr('id', 'svg_vis');

    rectangles = visualization.selectAll('g')
                              .data(nodes, function(node) {return node.id;});

    rectangles.enter().append("g")
                      .attr("x", function (d) { return d.x })
                      .attr("y", function (d) { return d.y });
              
    rectangles.append('image')  
            .attr("class", "child card")
            .attr('data_narrative_id', function(node) {return node.id})
            .attr("width", function(d) { return getWidth(d.id);})
            .attr("height", function(d) { return getHeight(d.id);})
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
          .attr('data_narrative_id', function(node) {return node.id})
          .attr("y", function (d) { return getWidth(d.id) * 0.85})
          .attr("class", "rect agree")
          .attr("width", function (d)
          {
                var likes = parseInt(d.yays);
                var dislikes = parseInt(d.nays);
                var numberOfVotes = (likes + dislikes == 0 ? 1 : likes + dislikes);
                var dislikesRatio = dislikes / numberOfVotes;
                var dislikesRectangleWidth = (dislikesRatio * stdThumbW) + (likes / numberOfVotes) * stdThumbW;
                return dislikesRectangleWidth;
          })
          .attr("height", (stdThumbH * 0.1))
          .attr("style", "fill:rgb(0,143,211);stroke-width:1;stroke:rgb(94,94,94);display:none;");

    rectangles.append("rect")
          .attr('data_narrative_id', function(node) {return node.id})
          .attr("y", function (d) { return getWidth(d.id) * 0.85})
          .attr("class", "rect disagree")
          .attr("width", function (d)
          {
                var likes = parseInt(d.yays);
                var dislikes = parseInt(d.nays);
                var numberOfVotes = (likes + dislikes == 0 ? 1 : likes + dislikes);
                var likesRatio = likes / numberOfVotes;
                var likesRectangleWidth = likesRatio * stdThumbW;
                return likesRectangleWidth;
          })
          .attr("height", (stdThumbH * 0.1))
          .attr("style", "fill:rgb(0,255,0);stroke-width:1;stroke:rgb(94,94,94);display:none;");

    rectangles.append("circle")
              .attr("style", "stroke: none; fill: none;")
              .attr("cx", function(d){return d.centerX;})
              .attr("cy", function(d){return d.centerY;})
              .attr("r", function(d){return d.radius;});
}

function start()
{
    force = d3.layout
              .force(100 * Math.sqrt(nodes.length / (width * height)))
              .nodes(nodes)
              .size([width, height]);
}

function mainGroupFilter()
{
    force.gravity(layoutGravity)
         .charge(charge)
         .friction(0.9)
         .on('tick', tickFunction);
    
    force.start();
}

function moveTowardsCenter(alpha)
{
    return function(d)
    {
        d.x = d.x + (center.x - d.x) * (damper + 0.02) * alpha;
        d.y = d.y + (center.y - d.y) * (damper + 0.02) * alpha;
    };
}

function charge(d)
{
    return -Math.pow(d.width, 2.0) / (15 * data.length);
}

function calculateSize()
{
    var windowSquareSize = (height > width ? (width * 0.8) : (height * 0.8));

    return Math.sqrt((Math.pow(windowSquareSize, 2) / data.length) / 2);
}

function printObject(o)
{
  var out = '';
  for (var p in o)
  {
    out += p + ': ' + o[p] + '\n';
  }
  alert(out);
}

function collide(node)
{
    var nodecx = node.centerX + node.x;
    var nodecy = node.centerY + node.y;

  var r = node.radius + 16,
      nx1 = node.cx - r,
      nx2 = node.cx + r,
      ny1 = node.cy - r,
      ny2 = node.cy + r;
  return function (quad, x1, y1, x2, y2)
  {
      if (quad.point && (quad.point !== node))
      {
          var quadcx = quad.point.centerX + quad.point.x;
          var quadcy = quad.point.centerY + quad.point.y;

          var x = nodecx - quadcx,
          y = nodecy - quadcy,
          l = Math.sqrt(x * x + y * y),
          r = node.radius + quad.point.radius;
          if (l < r)
          {
              l = (l - r) / l * 0.25;
              node.x -= x *= l;
              node.y -= y *= l;
              quad.point.x += x;
              quad.point.y += y;
          }
      }
      return x1 > nx2 || x2 < nx1 || y1 > ny2 || y2 < ny1;
  };
}

function findRadius(node)
{
    var diameter = Math.sqrt(node.width^2 + node.height^2);
    var radius = diameter / 2;
    return radius;
}

function setWithinBounds(x, length)
{
    return Math.max(15, Math.min(length - 15, x));
}

function getWidth(id)
{
    for (var i = 0; i < nodes.length; i++)
    {
        if (nodes[i]["id"] == id)
        {
            return nodes[i]["width"];
        }
    }
}

function getHeight(id)
{
    for (var i = 0; i < nodes.length; i++)
    {
        if (nodes[i]["id"] == id)
        {
            return nodes[i]["height"];
        }
    }
}

function findNode(id)
{
    for (var i = 0; i < nodes.length; i++)
    {
        if (nodes[i]["id"] == id)
        {
            return nodes[i];
        }
    }
}

function findDatum(id)
{
    for (var i = 0; i < data.length; i++)
    {
        if (data[i]["id"] == id)
        {
            return data[i];
        }
    }
}

function updatePositionRelativeToCenter(node, cxAbsolute, cyAbsolute)
{
    var cxRelative = node.centerX;
    var cyRelative = node.centerY;

    node.x += cxAbsolute - cxRelative;
    node.y += cyAbsolute - cyRelative;
}

function tickFunction(e)
{
    var q = d3.geom.quadtree(nodes);
    var i = 0;
    var n = nodes.length;
    while(++i < n) q.visit(collide(nodes[i]));

    rectangles.each(moveTowardsCenter(e.alpha))
        .attr("transform",function(d) {return "translate(" + d.x + "," + d.y + ")";});

    rectangles.selectAll("circle")
        .attr("cx", function(d) { return d.centerX; })
        .attr("cy", function(d) { return d.centerY; });
}
