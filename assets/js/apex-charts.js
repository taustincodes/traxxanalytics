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
var darkRed = '#be4057';
var lightRed = '#be4057';
var opaqueRed = 'rgba(190, 64, 87, 0.4)';
var opaqueGreen = 'rgba(64, 190, 167, 0.4)';
var lightGreen = '#40BEA7';
var darkGreen = '#40BEA7';
var grey = '#D3D3D3';
var lightBlue = '#40BEA7';
var midBlue = '#008873';
var darkBlue = '#205f53';

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
if (chartData) {
  var trades = JSON.parse(chartData.dataset.tradeHistory);
  var chartSeriesData = {
    percentageProfit: [],
    profitableTrades: {
      total: trades.length,
      profitable: 0,
    },
    dateTime: [],
    date: [],
    leverage: [],
    strategies: {
      names: [],
      successPercentages: []
    }
  };
  
  //Add rest of data
  for (let k of trades) {
    console.log(k.exitDateTime.slice(0,-9))
    chartSeriesData.percentageProfit.push(parseFloat(k.percentageProfit.toFixed(0)));
    chartSeriesData.dateTime.push(k.exitDateTime.slice(0,-9));
    chartSeriesData.date.push((k.exitDateTime.split('T')[0]));
  
    chartSeriesData.leverage.push(k.leverage);
    if (k.strategy) {
      if (!chartSeriesData.strategies.names.includes(k.strategy.name)) {
        chartSeriesData.strategies.names.push(k.strategy.name)
        chartSeriesData.strategies.successPercentages.push(k.strategy.successPercentage)
      }
    }
    if (k.percentageProfit >= 0) {
      chartSeriesData.profitableTrades.profitable += 1;
    }
    
  }
  console.log("Chart series data")
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
  console.log("TESDSSSSSSTER")
  
  var options = {
      series: [{
      name: 'Profit',
      data: chartSeriesData.percentageProfit
    }],
      chart: {
      type: 'bar',
      height: '100%',
      width: '100%',
      stacked: false
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
      type: 'datetime',
      categories: chartSeriesData.dateTime
    }
    };
    var chart = new ApexCharts(document.getElementById("#chart"), options);
    chart.render();

    var sparklineColor = chartSeriesData.percentageProfit[chartSeriesData.percentageProfit.length] >= chartSeriesData.percentageProfit[chartSeriesData.percentageProfit.length - 1] ? opaqueGreen :opaqueRed;
  
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
     colors: [sparklineColor]
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
      height: '100%',
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
    colors: [sparklineColor]
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
      series: [
        chartSeriesData.profitableTrades.profitable / chartSeriesData.profitableTrades.total * 100,
        (chartSeriesData.profitableTrades.total - chartSeriesData.profitableTrades.profitable) / chartSeriesData.profitableTrades.total * 100
      ],
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
    series: chartSeriesData.strategies.successPercentages,
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
    labels: chartSeriesData.strategies.names,
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
  colors: [darkBlue, lightBlue],
  xaxis: {
    type: 'string',
    categories: chartSeriesData.date,
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
}

//Home page 
var options = {
  series: [{
  name: 'TEAM A',
  type: 'column',
  data: [23, 11, 22, 27, 13, 22, 37, 21, 44, 22, 30]
}, {
  name: 'TEAM B',
  type: 'area',
  data: [44, 55, 41, 67, 22, 43, 21, 41, 56, 27, 43]
}, {
  name: 'TEAM C',
  type: 'line',
  data: [30, 25, 36, 30, 45, 35, 64, 52, 59, 36, 39]
}],
  chart: {
  toolbar: {
    show: false
  },
  width: '100%',
  height: '100%',
  type: 'line',
  stacked: false,
  animations: {
    enabled: true,
    easing: 'easeinout',
    speed: 800,
    animateGradually: {
        enabled: true,
        delay: 150
    },
    dynamicAnimation: {
        enabled: true,
        speed: 1000
    }
}
},
stroke: {
  width: [0, 2, 5],
  curve: 'smooth'
},
plotOptions: {
  bar: {
    columnWidth: '50%'
  }
},
fill: {
  type:'solid',
  opacity: [1, 0.3, 0.6],
},
colors: [lightGreen, lightBlue, darkBlue],
labels: ['01/01/2003', '02/01/2003', '03/01/2003', '04/01/2003', '05/01/2003', '06/01/2003', '07/01/2003',
  '08/01/2003', '09/01/2003', '10/01/2003', '11/01/2003'
],
markers: {
  size: 0
},
grid: {
  show:false
 },
 xaxis: {
  show: false,
  labels: {
    show: false
  },
  axisBorder: {
    show: false
  },
  axisTicks: {
    show: false
  }
},
yaxis: {
  show: false,
  title: {
    text: 'Points',
  },
  min: 0,
  axisTicks: {
    show: false,
},
},
legend: {
  show: false
},
tooltip: {
  enabled: false
}
};

var chart5 = new ApexCharts(document.getElementById("#homepage-chart"), options);
chart5.render();

var homepagePieOptions = {
  series: [23, 11, 22],
  chart: {

  type: 'radialBar',
  animations: {
    enabled: true,
    easing: 'easeinout',
    speed: 800,
    animateGradually: {
        enabled: true,
        delay: 150
    },
    dynamicAnimation: {
        enabled: true,
        speed: 1000
    }
}
  },
  plotOptions: {
    radialBar: {
      dataLabels: {
        show: false
      }
    }
  },
  colors: [lightBlue, midBlue, darkBlue],
  tooltip: {
    enabled: false
  },
   grid: {
    show:false
  }
  
};


var chart6 = new ApexCharts(document.getElementById("#homepage-pie-chart"), homepagePieOptions);
chart6.render();


for (let i = 1; i < 100; i++) {
  setTimeout(function timer() {
    chart5.updateSeries([{
      name:'TEAM A',
      data: Array.from({length: 11}, () => Math.floor(Math.random() * 50))
    }, {
      name:'TEAM B',
      data: Array.from({length: 11}, () => Math.floor(Math.random() * 50))
    }, {
      name:'TEAM C',
      data: Array.from({length: 11}, () => Math.floor(Math.random() * 50))
    }])
    chart6.updateSeries(
      Array.from({length: 3}, () => Math.floor(Math.random() * 100))
    )
  }, i * 3000);
}





