
$(document).ready(function () {
    var Lvl = $("#LvlSes").val();
    console.log(Lvl);
    if (Lvl == 0){
        $("#RealTimeUjianTkdb").html("<tr><td colspan='4' class='text-center'>Belum Ada Peserta</td></tr>")
        LoadDataPie();
        RealTimeNilaiTkdb();
        setInterval(function(){
            RealTimeUjianTkdb();
        }, 500);

        setInterval(function () {
            RealTimeNilaiTkdb();
            RealTimeFinishData();
        }, 10000);

        
       
    }
});

function Information(){
    jQuery("#modal").modal('show', { backdrop: 'static' });
    $("#Results").html("<div class='alert alert-warning'>Lengkapi data anda terlebih dahulu?</div>");
}

function LoadDataPie() {
    $.ajax({
        type: "POST",
        url: "inc/proses.php?proses=LoadDataCart",
        data: "rule=LoadData",
        success: function (res) {
            var r = JSON.parse(res);
            CahrData(r['Jp'], "pieJp");
            CahrData(r['Sert'], "pieSert");
            CahrData(r['Jk'], "pieJk");
        },
        error: function (er) {
            console.log(er);
        }
    })
}

function CahrData(data, Id) {
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $('#' + Id).get(0).getContext('2d')
    var pieChart = new Chart(pieChartCanvas)
    var PieData = data;

    var pieOptions = {
        //Boolean - Whether we should show a stroke on each segment
        segmentShowStroke: true,
        //String - The colour of each segment stroke
        segmentStrokeColor: '#fff',
        //Number - The width of each segment stroke
        segmentStrokeWidth: 2,
        //Number - The percentage of the chart that we cut out of the middle
        percentageInnerCutout: 50, // This is 0 for Pie charts
        //Number - Amount of animation steps
        animationSteps: 100,
        //String - Animation easing effect
        animationEasing: 'easeOutBounce',
        //Boolean - Whether we animate the rotation of the Doughnut
        animateRotate: true,
        //Boolean - Whether we animate scaling the Doughnut from the centre
        animateScale: false,
        //Boolean - whether to make the chart responsive to window resizing
        responsive: true,
        // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
        maintainAspectRatio: true,
        //String - A legend template
        legendTemplate: '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<segments.length; i++){%><li><span style="background-color:<%=segments[i].fillColor%>"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>'
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    pieChart.Doughnut(PieData, pieOptions)
}

function RealTimeFinishData(){
    $.ajax({
        type : "GET",
        url : "inc/proses.php",
        chace : false,
        data: "proses=ExecuteDataLama",
        success : function(res){
            var r = JSON.parse(res);
            console.log(res);
            
        },
        error : function(er){
            console.log(er);
        }
    })
}

function RealTimeUjianTkdb(){
    $.ajax({
        type : "GET",
        url : "inc/proses.php",
        chace : false,
        data: "proses=LoadRealTiimeTkdb",
        success : function(res){
            var r = JSON.parse(res);
            console.log(res);
            if(r['status'] = "sukses"){
                var html = "";
                var no=1;
                for(var i=0; i < r['data'].length; i++){
                    var iData = r['data'][i];
                    html += "<tr>";
                    html += "<td>" + no + "</td>";
                    html += "<td>" + iData['Nama'] + "</td>";
                    html += "<td>" + iData['Loker'] + "</td>";
                    html += "<td>" + iData['SisaWaktu'] + "</td>";
                    html += "<td></td>";
                    html += "</tr>";
                    no++;
                }
                $("#RealTimeUjianTkdb").html(html);
            }
        },
        error : function(er){
            console.log(er);
        }
    })
}

function RealTimeNilaiTkdb() {
    $.ajax({
        type: "GET",
        url: "inc/proses.php",
        chace: false,
        data: "proses=RealTimeNilaiTkdb",
        success: function (res) {
            var r = JSON.parse(res);
            if (r['status'] = "sukses") {
                var html = "";
                var no = 1;
                for (var i = 0; i < r['data'].length; i++) {
                    var iData = r['data'][i];
                    html += "<tr>";
                    html += "<td>" + no + "</td>";
                    html += "<td>" + iData['Nama'] + "</td>";
                    html += "<td>" + iData['Loker'] + "</td>";
                    html += "<td>" + iData['Nilai'] + "</td>";
                    html += "<td></td>";
                    html += "</tr>";
                    no++;
                }
                $("#RealTimeNilaiTkdb").html(html);
                $("[data-toggle='tooltip']").tooltip();
            }
        },
        error: function (er) {
            console.log(er);
        }
    })
}
