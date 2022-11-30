import ApexCharts from 'apexcharts'

function generateData(count, yrange) {
    var i = 0;
    var series = [];
    while (i < count) {
      var x = "w" + (i + 1).toString();
      var y =
        Math.floor(Math.random() * (yrange.max - yrange.min + 1)) + yrange.min;
  
      series.push({
        x: x,
        y: y
      });
      i++;
    }
    return series;
  }

var options = {
    series: [{
    name: 'Cash Flow',
    data: [1.45, 5.42, 5.9, -0.42, -12.6, -18.1, -18.2, -25.16, -30.1, -20, -15, -10, -5,
      5.8, 2, 3.37, -5.1, -3.57, 5.75, 7.1, 9.8, 9, 8, 10, 20, 25, 8.6, 1.1, 9.6, 7.6, 4, 1.4, 2.4
    ]
  }],
    chart: {
    type: 'bar',
    height: '100%',
    width: '100%'
  },
  plotOptions: {
    bar: {
      colors: {
        ranges: [{
          from: -1000,
          to: -25,
          color: '#880808'
        }, {
          from: -25,
          to: 0,
          color: '#D22B2B',
        }, {
            from: 1,
            to: 25,
            color: '#50C878'
        }, {
            from: 25,
            to: 1000,
            color: '#228B22'
        }]
      },
      columnWidth: '80%',
    }
  },
  dataLabels: {
    enabled: false,
  },
  yaxis: {
    title: {
      text: 'PnL',
    },
    labels: {
      formatter: function (y) {
        return y.toFixed(0) + "%";
      }
    }
  },
  xaxis: {
    type: 'datetime',
    categories: [
      '2021-01-01', '2021-02-01', '2021-03-01', '2021-04-01', '2021-05-01', '2021-06-01',
      '2021-07-01', '2021-08-01', '2021-09-01', '2021-10-01', '2021-11-01', '2021-12-01',
      '2022-01-01', '2022-02-01', '2022-03-01', '2022-04-01', '2022-05-01', '2022-06-01',
      '2022-07-01', '2022-08-01', '2022-09-01', '2022-10-01', '2022-11-01', '2022-12-01',
      '2023-01-01', '2023-02-01', '2023-03-01', '2023-04-01', '2023-05-01', '2023-06-01',
      '2023-07-01', '2023-08-01', '2023-09-01'
    ],
    labels: {
      rotate: -90
    }
  }
  };
  var chart = new ApexCharts(document.getElementById("#chart"), options);
  chart.render();

//   sparkline1
  var options = {
    series: [{
    data: [3,5,7,13,15,16,27,55,76]
  }],
    chart: {
    type: 'area',
    height: 160,
    sparkline: {
      enabled: true
    },
  },
  stroke: {
    curve: 'straight'
  },
  fill: {
    opacity: 0.3,
  },
  yaxis: {
    min: 0,
    max:100,
  },
   colors: ['#50C878']
//   title: {
//     text: '$424,652',
//     offsetX: 0,
//     style: {
//       fontSize: '24px',
//     }
//   },
//   subtitle: {
//     text: 'Sales',
//     offsetX: 0,
//     style: {
//       fontSize: '14px',
//     }
//   }
  };
  var chart = new ApexCharts(document.getElementById("#chart-spark1"), options);
  chart.render();

  //   sparkline1
  var options2 = {
    series: [{
    data: [16,27,55,76]
  }],
    chart: {
    type: 'area',
    height: 160,
    sparkline: {
      enabled: true
    },
  },
  stroke: {
    curve: 'straight'
  },
  fill: {
    opacity: 0.3,
  },
  yaxis: {
    min: 0,
    max:100,
  },
  colors: ['#50C878']
//   title: {
//     text: '$424,652',
//     offsetX: 0,
//     style: {
//       fontSize: '24px',
//     }
//   },
//   subtitle: {
//     text: 'Sales',
//     offsetX: 0,
//     style: {
//       fontSize: '14px',
//     }
//   }
  };
  var chart2 = new ApexCharts(document.getElementById("#chart-spark2"), options2);
  chart2.render();

  var options4 = {
    colors: ['#50C878', '#D22B2B'], 
    series: [78,22],
    labels: ["Percentage Win", "Percentage Loss"],
    chart: {
    type: 'donut',
    height: "50%",
    sparkline: {
      enabled: true
    }
  },
  stroke: {
    width: 1
  },
  tooltip: {
    fixed: {
      enabled: false
    },
  }
  };

  var chart4 = new ApexCharts(document.getElementById("#chart-4"), options4);
  chart4.render();


//   Heat map

var options = {
    series: [
        {
          name: "Strategy 1",
          data: generateData(20, {
            min: -50,
            max: 50
          })
        },
        {
          name: "Strategy 2",
          data: generateData(20, {
            min: -50,
            max: 50
          })
        },
        {
          name: "Strategy 3",
          data: generateData(20, {
            min: -50,
            max: 50
          })
        }
    ],
      chart: {
        type: 'heatmap',
        height: '100%',
        width: '100%'
      },
  dataLabels: {
    enabled: false
  },
  legend: {
    show: false,
  },
  plotOptions: {
    heatmap: {
        colorScale: {
            ranges: [{
                from: -50,
                to: -26,
                color: '#880808'
              }, {
                from: -25,
                to: -1,
                color: '#D22B2B',
              }, {
                  from: 1,
                  to: 25,
                  color: '#50C878'
              }, {
                  from: 26,
                  to: 50,
                  color: '#228B22'
              }]
            },
    }
    

  },
  
  };

  var chart = new ApexCharts(document.getElementById("#heatmap-chart"), options);
  chart.render();

// // scatter
// var options = {
//   series: [{
//   name: "SAMPLE A",
//   data: [
//   [1, 5], [1, 2], [1, 3], [2, 6], [2, 10], [3, 10], [3, 20], [3, 20], [5, 8], [20, 50], [20, -10], [20, -15], [5, 10], [2, 0], [27.1, 52.3], [16.4, 0], [13.6, 3.7], [10.9, 5.2], [16.4, 6.5], [10.9, 0], [24.5, 7.1], [10.9, 0], [8.1, 4.7], [19, 0], [21.7, 1.8], [27.1, 0], [24.5, 0], [27.1, 0], [29.9, 1.5], [27.1, 0.8], [22.1, 2]]
// }],
//   chart: {
//   height: "100%",
//   width: "100%",
//   type: 'scatter',
//   zoom: {
//     enabled: true,
//     type: 'xy'
//   }
// },
// xaxis: {
//   position: 'left',
//   tickAmount: 5,
//   tickPlacement: 'on',
//   min: 0,
//   max: 100,
//   title: {
//     text: 'PnL',
//   },
//   labels: {
//     formatter: function(val) {
//       return parseFloat(val).toFixed(1)
//     }
//   },
  
// },
// yaxis: {
//   tickAmount: 7,
//   title: {
//     text: 'PnL',
//   },
// }
// };

// var chart = new ApexCharts(document.getElementById("#scatter-chart"), options);
// chart.render();

var options = {
  series: [{
  name: 'Leverage',
  type: 'line',
  data: [{
      x: 1996,
      y: 1
    },
    {
      x: 1997,
      y: 5
    },
    {
      x: 1998,
      y: 2
    },
    {
      x: 1999,
      y: 2
    },
    {
      x: 2000,
      y: 10
    },
    {
      x: 2001,
      y: 10
    },
    {
      x: 2002,
      y: 3
    },
    {
      x: 2003,
      y: 1
    },
   
  ]
}, {
  name: 'Percentage Profit',
  type: 'area',
  data: [
    {
      x: 1996,
      y: 20
    },
    {
      x: 1997,
      y: 14
    },
    {
      x: 1998,
      y: 12
    },
    {
      x: 1999,
      y: -12
    },
    {
      x: 2000,
      y: -5
    },
    {
      x: 2001,
      y: 0
    },
    {
      x: 2002,
      y: -20
    },
    {
      x: 2003,
      y: 21
    },
  ]
}],
  chart: {
  type: 'line',
  height: "100%",
  width: "100%"
},
dataLabels: {
  enabled: false
},
stroke: {
  curve: 'straight'
},
fill: {
  type:'solid',
  opacity: [0.35, 1],
},

xaxis: {
  type: 'datetime',
  axisBorder: {
    show: false
  },
  axisTicks: {
    show: false
  }
},
yaxis: [{
  tickAmount: 4,
  floating: false,
  title: {
    text: "Leverage"
  },
  labels: {
    style: {
      colors: '#8e8da4',
    },
    offsetY: -7,
    offsetX: 0,
  },
  axisBorder: {
    show: false,
  },
  axisTicks: {
    show: false
  }
},
{
  opposite: true,
  title: {
    text: "Percentage Profit"
  }
}],
fill: {
  opacity: 0.5
},
tooltip: {
  x: {
    format: "yyyy",
  },
  fixed: {
    enabled: false,
    position: 'topRight'
  }
},
grid: {
  yaxis: {
    lines: {
      offsetX: -30
    }
  },
  padding: {
    left: 20
  }
}
};

var chart = new ApexCharts(document.getElementById("#leverage-chart"), options);
chart.render();






