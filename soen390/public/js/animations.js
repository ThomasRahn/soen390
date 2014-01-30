var data    = null;
var width   = window.innerWidth;
var height  = window.innerHeight - 100;

var visualization   = null;
var layoutGravity   = -0.01;
var damper          = 0.1;
var rectangles      = null;
var nodes           = Array();
var force           = null;

center = {
        x: width / 2,
        y: height / 2
      };

function initiate()
{
    //data = d3.csv("data/positions.csv", parseCsv);
    data = d3.json("/api/narrative", parseJson);
}

function parseCsv(error, csv)
{
    if (error)
    {
        alert("CSV error" + error);
        return;
    }
    
    data = csv;

    createNodes();
    createVisualization();
    start();
    main_group_filter();
}

function parseJson(error, json)
{
    if (error)
    {
        alert("JSON error" + error);
        return;
    }

    data = json;

    createNodes();
    createVisualization();
    start();
    main_group_filter();
}

function createNodes()
{
    data.forEach(function (d) {
        node =
        { id: d.id,
            width: 70,
            height: 70,
            group: d.group,
            year: d.start_year,
            image_link: d.image_link,
            language: d.language,
            x: Math.random() * 900,
            y: Math.random() * 800
        };

        nodes.push(node);
    });
}

function createVisualization()
{
    visualization = d3.select("#view")
                      .append("svg")
                      .attr("width", width)
                      .attr("height", height)
                      .attr("id", "svg_vis");
    
    rectangles = visualization.selectAll("image").data(nodes, function (d) { return d.id; });

    rectangles.enter().append("image")
                      .attr("width", 75)
                      .attr("height", 75)
                      .attr("xlink:href", function (d) { return d.image_link });
}

function charge(d)
{
    return -Math.pow(d.width, 2.0) / 8;
}

function start()
{
    force = d3.layout.force()
              .nodes(nodes)
              .size([width, height]);
}

function main_group_filter()
{
    force.gravity(layoutGravity)
         .charge(charge)
         .friction(0.9)
         .on("tick", function (e) {
             return rectangles.each(move_towards_center(e.alpha))
                              .attr("x", function (d) { return d.x })
                              .attr("y", function (d) { return d.y });
         });

         force.start();
}

function move_towards_center(alpha)
{
    return function (d) {
        d.x = d.x + (center.x - d.x) * (damper + 0.02) * alpha;
        d.y = d.y + (center.y - d.y) * (damper + 0.02) * alpha;
    }
}

