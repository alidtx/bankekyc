/* eslint-disable object-curly-newline */

/* global Chart */

/**
 * --------------------------------------------------------------------------
 * CoreUI Boostrap Admin Template (v3.2.0): main.js
 * Licensed under MIT (https://coreui.io/license)
 * --------------------------------------------------------------------------
 */

/* eslint-disable no-magic-numbers */
// random Numbers
var random = function random(a = 100) {
    return Math.round(Math.random() * a);
}; // eslint-disable-next-line no-unused-vars


// var lineChart = new Chart(document.getElementById('canvas-1'), {
//   type: 'line',
//   data: {
//     labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
//     datasets: [{
//       label: 'My First dataset',
//       backgroundColor: 'rgba(220, 220, 220, 0.2)',
//       borderColor: 'rgba(220, 220, 220, 1)',
//       pointBackgroundColor: 'rgba(220, 220, 220, 1)',
//       pointBorderColor: '#fff',
//       data: [random(), random(), random(), random(), random(), random(), random()]
//     }, {
//       label: 'My Second dataset',
//       backgroundColor: 'rgba(151, 187, 205, 0.2)',
//       borderColor: 'rgba(151, 187, 205, 1)',
//       pointBackgroundColor: 'rgba(151, 187, 205, 1)',
//       pointBorderColor: '#fff',
//       data: [random(), random(), random(), random(), random(), random(), random()]
//     }]
//   },
//   options: {
//     responsive: true
//   }
// }); // eslint-disable-next-line no-unused-vars

// var barChart = new Chart(document.getElementById('canvas-2'), {
//     type: 'bar',
//     data: {
//         labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
//         datasets: [{
//             backgroundColor: [0,1,1,2,3,4,5,6,7,8,10,11].map(el=>'rgba(' + random(250) + ',' + random(250) + ',' + random(255) +',' + 0.9+ ')'),
//             borderColor: 'rgba(241,153,14,0.8)',
//             highlightFill: 'rgba(219,11,59,0.75)',
//             highlightStroke: 'rgb(16,51,224)',
//             data: [random(), random(), random(), random(), random(), random(), random(), random(), random(), random(), random(), random()]
//         }]
//     },
//     options: {
//         responsive: true,
//         legend: {
//             display: false
//         },
//         scales: {
//             xAxes: [{
//                 scaleLabel: {
//                     display: true,
//                     labelString: 'Volunteer Hours',
//                 },
//                 gridLines: {
//                     display: false,
//                     drawBorder: false //<- set this
//                 },
//             }],
//             yAxes: [{
//                 gridLines: {
//                     display: true,
//                     drawBorder: true //<- set this
//                 }
//             }]
//         }
//     }
// }); // eslint-disable-next-line no-unused-vars

// var doughnutChart = new Chart(document.getElementById('canvas-3'), {
//     type: 'doughnut',
//     data: {
//         labels: ['Red', 'Green', 'Yellow'],
//         datasets: [{
//             data: [300, 50, 100],
//             backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56'],
//             hoverBackgroundColor: ['#FF6384', '#36A2EB', '#FFCE56']
//         }]
//     },
//     options: {
//         responsive: true
//     }
// }); // eslint-disable-next-line no-unused-vars

// var radarChart = new Chart(document.getElementById('canvas-4'), {
//   type: 'radar',
//   data: {
//     labels: ['Eating', 'Drinking', 'Sleeping', 'Designing', 'Coding', 'Cycling', 'Running'],
//     datasets: [{
//       label: 'My First dataset',
//       backgroundColor: 'rgba(220, 220, 220, 0.2)',
//       borderColor: 'rgba(220, 220, 220, 1)',
//       pointBackgroundColor: 'rgba(220, 220, 220, 1)',
//       pointBorderColor: '#fff',
//       pointHighlightFill: '#fff',
//       pointHighlightStroke: 'rgba(220, 220, 220, 1)',
//       data: [65, 59, 90, 81, 56, 55, 40]
//     }, {
//       label: 'My Second dataset',
//       backgroundColor: 'rgba(151, 187, 205, 0.2)',
//       borderColor: 'rgba(151, 187, 205, 1)',
//       pointBackgroundColor: 'rgba(151, 187, 205, 1)',
//       pointBorderColor: '#fff',
//       pointHighlightFill: '#fff',
//       pointHighlightStroke: 'rgba(151, 187, 205, 1)',
//       data: [28, 48, 40, 19, 96, 27, 100]
//     }]
//   },
//   options: {
//     responsive: true
//   }
// }); // eslint-disable-next-line no-unused-vars

// var pieChart = new Chart(document.getElementById('canvas-5'), {
//     type: 'pie',
//     data: {
//         labels: ['Dhaka', 'Chattagram', 'Barishal', 'Gazipur', 'Nilphamari', 'Othes'],
//         datasets: [{
//             data: [582320, 458242, 369542, 258452, 265842, 765240],
//             backgroundColor: [1, 2, 3, 4, 5, 6].map(el => 'rgb(' + random(255) + ',' + random(255) + ',' + random(255) + ')'),
//             hoverBackgroundColor: ['#FF6384', '#36A2EB', '#d2e80c', '#0fdcc4', '#FFF10C7A'],
//         }]
//     },
//     options: {
//         responsive: true
//     }
// }); // eslint-disable-next-line no-unused-vars

// var polarAreaChart = new Chart(document.getElementById('canvas-6'), {
//     type: 'polarArea',
//     data: {
//         labels: ['Red', 'Green', 'Yellow', 'Grey', 'Blue'],
//         datasets: [{
//             data: [11, 16, 7, 3, 14],
//             backgroundColor: ['#FF6384', '#4BC0C0', '#FFCE56', '#E7E9ED', '#36A2EB']
//         }]
//     },
//     options: {
//         responsive: true
//     }
// });
//# sourceMappingURL=charts.js.map
