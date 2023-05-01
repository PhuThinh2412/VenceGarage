var dom = document.getElementById('chart-container');
var myChart = echarts.init(dom, null, {
  renderer: 'canvas',
  useDirtyRect: false
});
var app = {};
var ROOT_PATH = 'http://garage-app.test/';
var option;

myChart.showLoading();
$.get(ROOT_PATH + 'api/parking-data', function (diskData) {
  myChart.hideLoading();
  const formatUtil = echarts.format;
  function getLevelOption() {
    return [
      {
        itemStyle: {
          borderWidth: 0,
          gapWidth: 5
        }
      },
      {
        itemStyle: {
          gapWidth: 1
        }
      },
      {
        colorSaturation: [0.35, 0.36],
        itemStyle: {
          gapWidth: 1,
          borderColorSaturation: 0.6
        }
      }
    ];
  }
  myChart.setOption(
    (option = {
      title: {
        text: 'Parking Usage',
        left: 'center'
      },
      tooltip: {
        formatter: function (info) {
          var value = info.value;
          var treePathInfo = info.treePathInfo;
          var treePath = [];
          console.log(info.data.parkingLevel);
          for (var i = 1; i < treePathInfo.length; i++) {
            treePath.push(treePathInfo[i].name);
          }
          if (info.data.status == 'Free') {
            $statusStr =  "<span style='color:green;'>" + 'Status' + ': ' + info.data.status + "</span>";
          } else {
            $statusStr =  "<span style='color:red;'>" + 'Status' + ': ' + info.data.status + "</span>";
          }
          return [
            '<div class="tooltip-title">' +
              'Parking Name: ' + formatUtil.encodeHTML(treePath.join('-')) +
              '<br>' + 
              $statusStr +
              '</div>',
            'Parking Level ' + info.data.parkingLevel
          ].join('');
        }
      },
      series: [
        {
          name: 'Parking Usage',
          type: 'treemap',
          visibleMin: 100,
          label: {
            show: true,
            formatter: '{b}'
          },
          itemStyle: {
            borderColor: '#fff'
          },
          levels: getLevelOption(),
          data: diskData
        }
      ]
    })
  );
});

if (option && typeof option === 'object') {
  myChart.setOption(option);
}

window.addEventListener('resize', myChart.resize);

