import ApexCharts from 'apexcharts'

// //Colors
// var darkRed = '#880808';
// var lightRed = '#D22B2B';
// var lightGreen = '#50C878';
// var darkGreen = '#228B22';
// var grey = '#D3D3D3';
// var lightBlue = '#73c2fb';
// var midBlue = '#1e90ff';
// var darkBlue = '#0047ab';

//Colors
var darkRed = '#D9A9FF';
var lightRed = '#D9A9FF';
var lightGreen = '#40BEA7';
var darkGreen = '#40BEA7';
var grey = '#D3D3D3';
var lightBlue = '#0075E0';
var midBlue = '#0049C4';
var darkBlue = '#120A8F';

// {
//   name: "Apple",
//   data: [{
//     x: '1',
//     y: 10
//   }, {
//     x: '2',
//     y: 20
//   },{
//     x: '3',
//     y: 30
//   },]
// },



var chartData = document.querySelector('.chart-data');
var trades = JSON.parse(chartData.dataset.tradeHistory);
var strategies = JSON.parse(chartData.dataset.strategiesHistory);

var chartSeriesData = {
  percentageProfit: [],
  dateTime: [],
  leverage: [],
  strategies: strategies
};


//Add rest of data
for (let k of trades) {
  chartSeriesData.percentageProfit.push(parseFloat(k.percentageProfit.toFixed(0)));
  chartSeriesData.dateTime.push((k.exitDateTime.split('T')[0]));
  chartSeriesData.leverage.push(k.leverage);
}
console.log(chartSeriesData)

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
    // console.log(series[0].x)
    console.log(series)

    return series;
  }


var options = {
    series: [{
    name: 'Profit',
    data: chartSeriesData.percentageProfit
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
          color: darkRed
        }, {
          from: -25,
          to: 0,
          color: lightRed,
        }, {
            from: 0,
            to: 25,
            color: lightGreen
        }, {
            from: 25,
            to: 1000,
            color: darkGreen
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
      showDuplicates: true,
      formatter: function (y) {
        return y.toFixed(0) + "%";
      }
    }
  },
  xaxis: {
    type: 'string',
    categories: chartSeriesData.dateTime,
    labels: {
      rotate: -45
    }
  }
  };
  var chart = new ApexCharts(document.getElementById("#chart"), options);
  chart.render();

//   sparkline1
  var options = {
    series: [{
    data: chartSeriesData.percentageProfit
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
    max:  Math.max(...chartSeriesData.percentageProfit) + Math.max(...chartSeriesData.percentageProfit) / 10,
  },
   colors: [lightRed]
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

  //   sparkline2
  var options2 = {
    series: [{
    data: chartSeriesData.percentageProfit.slice(-5)
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
    max:Math.max(...chartSeriesData.percentageProfit.slice(-5)) + Math.max(...chartSeriesData.percentageProfit.slice(-5)) / 10,
  },
  colors: [lightRed]
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
    colors: [lightGreen, lightRed], 
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

var pieChartOptions = {
  series: chartSeriesData.strategies.data,
  chart: {
  height: '100%',
  width: '100%',
  type: 'radialBar',
  },
  plotOptions: {
    radialBar: {
      dataLabels: {
        name: {
          fontSize: '22px',
          offsetY: 125,
          show: true
        },
        value: {
          fontSize: '16px',
          offsetY: -10,
          show: true
        },
        total: {
          show: true,
          label: 'Average Success',
          color: '#000000',
          formatter: function (val) {
            console.log('Formatter')
            var categoryValues = val.globals.seriesTotals;
            var average = categoryValues.reduce((a, b) => a + b, 0);
            var numberOfCategories = categoryValues.length;
            return (average / numberOfCategories).toFixed(2) + '%'
          }
        }
      },      
    }
  },
  colors: [lightBlue, midBlue, darkBlue],
  labels: chartSeriesData.strategies.categories,
  responsive: [{
    breakpoint: 480,
    options: {
      chart: {
        width: 200
      },
      legend: {
        position: 'bottom'
      }
    }
  }]
};

var options = {
    series: [
      //Need to return these programicitally
      chartSeriesData.strategies[0],chartSeriesData.strategies[1]
    //   {
    //   name: "Apple",
    //   data: [{
    //     x: '1',
    //     y: 10
    //   }, {
    //     x: '2',
    //     y: 20
    //   },{
    //     x: '3',
    //     y: 30
    //   },]
    // },
    // {
    //   name: "Apple",
    //   data: [{
    //     x: '1',
    //     y: 10
    //   }, {
    //     x: '2',
    //     y: null
    //   },{
    //     x: '3',
    //     y: 30
    //   },]
    // }
      
        // {
        //   name: "Strategy 1",
        //   data: generateData(20, {
        //     min: -50,
        //     max: 50
        //   })
        // },
        // {
        //   name: "Strategy 2",
        //   data: generateData(20, {
        //     min: -50,
        //     max: 50
        //   })
        // },
        // {
        //   name: "Strategy 3",
        //   data: generateData(20, {
        //     min: -50,
        //     max: 50
        //   })
        // }
    ],
      chart: {
        type: 'heatmap',
        height: '100%',
        width: '200%'
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
              }, {
                from: null,
                to: null,
                color: '#ececec'
              }]
            },
    }
    

  },
  
  };

  var chart = new ApexCharts(document.getElementById("#heatmap-chart"), pieChartOptions);
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
  data: chartSeriesData.leverage
}, {
  name: 'Percentage Profit',
  type: 'area',
  data: chartSeriesData.percentageProfit
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
  curve: ['straight', 'smooth', ]
},
fill: {
  type:'solid',
  opacity: [1, 1],
},
colors: [midBlue, darkBlue],
xaxis: {
  type: 'string',
  categories: chartSeriesData.dateTime,
  labels: {
    rotate: -45
  }
}
,
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






