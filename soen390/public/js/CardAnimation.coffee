class CardLayout
{
    constructor: (data) ->
    {
        @data   = data
        @width  = 940
        @height = 650

        @layout_gravity = -0.01
        @damper         = 0.1

        @vis = null
        @nodes = []
        @force = null
        @cards = null

        this.create_nodes()
        this.create_vis()
    }

    create_nodes: () =>
    {
        @data.forEach (d) =>
        {
            node = {category_id:     d.category_id
                    language_id:     d.language_id
                    date_created:    d.date_created
                    date_modified:   d.date_modified
                    name:            d.name
                    flags:           d.flags
                    views:           d.views
                    agree:           d.agree
                    indifferent:     d.indifferent
                    disagree:        d.disagree
                    isVisible:       d.isVisible}

            @nodes.push node
        }

        @nodes.sort (a,b) ->
        {
            b.value - a.value
        }
    }

    create_animation: () =>
    {
        @view = d3.select("#view").append("svg")
                  .attr("width", @width)
                  .attr("height", @height)
                  .attr("id", "svg_view")

        @rectangles = @view.selectAll("image").data(@nodes, (d) -> d.id)
    }
}

root = exports ? this

$ ->
  chart = null

  render_vis = (csv) ->
    alert csv
    chart = new BubbleChart csv
    chart.start()
    root.display_all()
  root.display_all = () =>
    chart.display_group_all()
  root.display_year = () =>
    chart.display_by_year()
  root.toggle_view = (view_type) =>
    if view_type == 'year'
      root.display_year()
    else
      root.display_all()

  d3.csv "data/positions.csv", render_vis