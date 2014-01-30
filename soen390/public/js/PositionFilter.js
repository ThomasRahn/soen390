var positionGravityCenters =
{
    "for"           : { x: width / 3,     y: height / 2 },
    "on the fence"  : { x: width / 2,     y: height / 2 },
    "against"       : { x: 2 * width / 3, y: height / 2 }
};

function filterByPosition()
{
    force.gravity(layoutGravity)
         .charge(charge)
         .friction(0.9)
         .on("tick", function (e) 
         {
             return rectangles.each(move_towards_position(e.alpha))
                              .attr("x", function (d) { return d.x })
                              .attr("y", function (d) { return d.y });
         });

         force.start();
}

function move_towards_position(alpha)
{
    return function (d) 
    {
        var target = positionGravityCenters[d.year];

        d.x = d.x + (target.x - d.x) * (damper + 0.02) * alpha;
        d.y = d.y + (target.y - d.y) * (damper + 0.02) * alpha;
    }
}