/* globals Chart:false, feather:false */

(function () {
  'use strict'

  feather.replace({ 'aria-hidden': 'true' })

  // Graphs
  var ctx = document.getElementById('myChart')
  // eslint-disable-next-line no-unused-vars
  var myChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: [
        'Sunday',
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday',
        'Saturday'
      ],
      datasets: [{
        data: [
          15339,
          21345,
          18483,
          24003,
          23489,
          24092,
          12034
        ],
        lineTension: 0,
        backgroundColor: 'transparent',
        borderColor: '#007bff',
        borderWidth: 4,
        pointBackgroundColor: '#007bff'
      }]
    },
    options: {
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: false
          }
        }]
      },
      legend: {
        display: false
      }
    }
  })
})

const jns_kata = document.getElementById("jns_kata");
const hide = document.getElementsByClassName("hide");

jns_kata.addEventListener("change", function () {
    // console.log(hide);
    if (jns_kata.value === "verba") {
      for(var i=0; i < hide.length; i++) {
        hide[i].style.display = "block";
      }
    } else {
      for(var i=0; i < hide.length; i++) {
        hide[i].style.display = "none";
      }
    }
});
