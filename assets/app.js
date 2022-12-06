/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';


// start the Stimulus application
import './bootstrap';
import 'bootstrap'; //adds functions to jquery

import 'jquery';
import './js/pagination'
import './js/apex-charts'

// global.$ = $; 
// Not needed unless we have Jquery in templates and need global $

// import Chart from 'chart.js';

// const data = [10, -20, 40, -30, 0, 55, -60];
//     var colours = data.map((value) => value < 0 ? 'red' : 'green');
//     var options = {
//         responsive:true,
//         maintainAspectRatio: false,
//         legend: { display: false },
//         scales: {
//             xAxes: [{
//                 scaleLabel: {
//                     display: true,
//                     labelString: 'Date'
//                 },
//                 gridLines: {
//                     display: true,
//                     drawBorder: true,
//                     drawOnChartArea: false
//                 },
//                 ticks: {    
                    
            
//                 },             
//             }],
//             yAxes: [{
//                 gridLines: {
//                     display: true,
//                     drawBorder: true,
//                     drawOnChartArea: true
//                 },
//                 ticks: {
             
//                 },
//                 scaleLabel: {
//                     display: true,
//                     labelString: 'PNL'
//                 },
//             }]
//         }
//     }

//     new Chart(
//         document.getElementById('acquisitions'),
//         {
//         type: 'bar',
//         options: options,
//         data: {
//             labels: ["01/11", "02/11", "03/11", "04/11", "05/11", "06/11", "07/11"],
//             datasets: [
//             {
//                 label: 'Past 7 days',
//                 data: data,
//                 borderColor: colours,
//                 backgroundColor: colours
//             }
//             ]
//         }
//         }
//     );


console.log("Webpack working!!!");

// $("#tester").click(function() {
//     console.log(1234)
//     //$(".table-card").fadeOut(50000); //if there are other elements in this div you want to preserve, keep in mind this will remove those too.
//     $('.table-card').fadeOut(500, function() {
//         $(".table-card").html('<h5 class="card-title">Edit Trade</h5>').fadeIn(500);
//     });
   
// });

// $("#tester").on( "click", function() {
//     console.log( 123 );
// });
// $('delete-button').confirmButton({
//     confirm
// })
