@extends('layouts.app')

@section('content')
  
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="description here">
    <meta name="keywords" content="keywords,here">
	
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.min.js" integrity="sha256-XF29CBwU1MWLaGEnsELogU6Y6rcc5nCkhhx89nFMIDQ=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.tutorialjinni.com/jquery-csv/1.0.11/jquery.csv.min.js"></script>
    <script type="text/javascript" src="//unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

	<style>
		.bg-black-alt  {
			background:#161616;
		}
		.text-black-alt  {
			color:#191919;
		}
		.border-black-alt {
			border-color: #191919;
		}
		
	</style>

</head>

<body class="bg-RFM-Black font-sans leading-normal tracking-normal">

        <script>
                /* When the user scrolls down, hide the navbar. When the user scrolls up, show the navbar */
            var prevScrollpos = window.pageYOffset;
            window.onscroll = function() {
            var currentScrollPos = window.pageYOffset;
            if (prevScrollpos > currentScrollPos) {
                document.getElementById("header").style.top = "0";
            } else {
                document.getElementById("header").style.top = "-150px";
            }
            prevScrollpos = currentScrollPos;
            }

            let array = [];
                            let arr = JSON.parse({!! json_encode($data) !!});
                            arr.forEach((current)=>{
                                newArray = {
                                    x: current['frequency'],
                                    y: current['recency'],
                                    r: 2,
                                    cleintID: current['customer_id'],
                                    cleintStatus: current['segment'],
                                    totalRevenue: current['monetary']
                                 }
                                array.push(newArray)
                            })
                          

                            Array.prototype.sum = function (prop) {
                            var sum = 0
                            for ( var i = 0, _len = this.length; i < _len; i++ ) {
                                sum += this[i][prop]
                            }
                            return sum
                        }

                        total = array.sum("totalRevenue")
                        let newCustomers = 0;
                        for (let i = 0; i < array.length; i++) {
                        if (array[i].cleintStatus == 'New Customers') newCustomers++;
                        }
                        
                        let list = [];
                        let downloadArr = JSON.parse({!! json_encode($data) !!});
                        downloadArr.forEach((old)=>{
                                secArray = {
                                    customer_id: old['customer_id'],
                                    recency: old['recency'],
                                    frequency: old['frequency'],
                                    monetary: old['monetary'],
                                    recency_score: old['recency_score'],
                                    frequency_score: old['frequency_score'],
                                    monetary_score: old['monetary_score'],
                                    rfm_score: old['rfm_score'],
                                    segment: old['segment']
                                    
                                 }
                                list.push(secArray)
                            })
               
                       
                        
        </script>
<nav id="header" class="bg-RFM-Black fixed w-full z-10 top-0 shadow">
	

		<div class="w-full container mx-auto flex flex-wrap items-center mt-0 pt-3 pb-3 md:pb-0">	
			<div class="w-1/2 pl-2 md:pl-0">
            <div class="w-full flex-grow lg:flex lg:items-center lg:w-auto hidden lg:block mt-2 lg:mt-0 bg-RFM-Black z-20" id="nav-content">
				<ul class="list-reset lg:flex flex-1 items-center px-4 md:px-0">
					<li class="mr-6 my-2 md:my-0">
                        <a href="{{ url('/') }}" class="block py-1 md:py-3 pl-1 align-middle text-gray-500 no-underline hover:text-gray-100 border-b-2 border-gray-900  hover:border-RFM-Pink">
                            <i class="fas fa-home fa-fw mr-3"></i><span class="pb-1 md:pb-0 text-sm">Home</span>
                        </a>
                    </li>
                    @if (Laratrust::hasRole('admin'))
                    @auth
					<li class="mr-6 my-2 md:my-0">
                        <a href="#"  onclick="window.location.href='/edit-users'" class="block py-1 md:py-3 pl-1 align-middle text-gray-500 no-underline hover:text-gray-100 border-b-2 border-gray-900  hover:border-RFM-Pink">
                            <i class="fas fa-tasks fa-fw mr-3"></i><span class="pb-1 md:pb-0 text-sm">Edit Roles and Permessions</span>
                        </a>
                    </li>
                    @endauth
                    @endif
				</ul>	
			</div>
            </div>
			<div class="w-1/2 pr-0">
				<div class="flex relative inline-block float-right">
                @if (Route::has('login'))
                <div class="space-x-4">
                    @auth
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="w-full bg-gradient-to-br from-RFM-Pink to-RFM-Orange hover:text-RFM-Black border border-transparent rounded-md py-2 px-4 flex items-center justify-center text-base font-medium text-white hover:bg-RFM-Pink_hover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-indigo-500">Log out</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                    @endauth
                </div>
                 @endif
			</div>


		
			
		</div>
	</nav>


    
	<!--Container-->
	<div class="container w-full mx-auto pt-20">
		
		<div class="w-full px-4 md:px-0 md:mt-8 mb-16 text-gray-800 leading-normal">
			
			<!--Console Content-->
			
			<div class="flex flex-wrap">
                <div class="w-full md:w-1/2 xl:w-1/3 p-3">
                    <!--Metric Card-->
                    <div class="p-0.5 bg-gradient-to-tr from-RFM-Cyan to-RFM-Orange rounded shadow">
                    <div class="bg-RFM-Black">
                        <div class="flex flex-row items-center">
                            <div class="flex-shrink pr-4">
                                <div class="rounded p-3"><i class="fas fa-wallet" style="font-size:30px; color:gray"></i></div>
                            </div>

                            <div class="flex-1 text-right md:text-center">
                                <h5 class="text-base font-extrabold text-2xl text-gray-400">Total Revenue</h5>
                                <h3 id="total" class="block text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-br from-RFM-Pink to-RFM-Orange">&euro;<script>document.write( Math.ceil(total))</script><span class="text-green-500"><i class="fas fa-caret-up"></i></span></h3>
                            </div>
                        </div>
                        </div>
                    </div>
                    <!--/Metric Card-->
                </div>
                <div class="w-full md:w-1/2 xl:w-1/3 p-3">
                    <!--Metric Card-->
                    <div class="p-0.5 bg-gradient-to-tr from-RFM-Cyan to-RFM-Orange rounded shadow">
                    <div class="bg-RFM-Black">
                        <div class="flex flex-row items-center">
                            <div class="flex-shrink pr-4">
                                <div class="rounded p-3"><i class="fas fa-users" style="font-size:30px; color:gray"></i></div>
                            </div>
                            <div class="flex-1 text-right md:text-center">
                                <h5 class="text-base font-extrabold text-2xl text-gray-400">Total Customers</h5>
                                <h3 class="block text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-br from-RFM-Pink to-RFM-Orange"><script>document.write(array.length)</script> <span class="text-pink-500"><i class="fas fa-exchange-alt"></i></span></h3>
                            </div>
                        </div>
                        </div>
                    </div>
                    <!--/Metric Card-->
                </div>
                <div class="w-full md:w-1/2 xl:w-1/3 p-3">
                    <!--Metric Card-->
                    <div class="p-0.5 bg-gradient-to-tr from-RFM-Cyan to-RFM-Orange rounded shadow">
                    <div class="bg-RFM-Black">
                        <div class="flex flex-row items-center">
                            <div class="flex-shrink pr-4">
                                <div class="rounded p-3"><i class="fas fa-user-plus"style="font-size:30px; color:gray"></i></div>
                            </div>
                            <div class="flex-1 text-right md:text-center">
                                <h5 class="text-base font-extrabold text-2xl text-gray-400">New Customers</h5>
                                <h3 class="block text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-br from-RFM-Pink to-RFM-Orange"><script>document.write(newCustomers)</script> <span class="text-green-600"><i class="fas fa-caret-up"></i></span></h3>
                            </div>
                        </div>
                        </div>
                    </div>
                    <!--/Metric Card-->
                </div>
                
            </div>
<!-- 
            <div class="p-0.5 bg-gradient-to-tr from-RFM-Cyan to-RFM-Orange rounded shadow">
                    <div class="bg-RFM-Black"> -->

			<!--Divider-->
         
			<div class="bg-gradient-to-tr from-RFM-Cyan to-RFM-Orange my-8 mx-4"></div>
                  
           

            <div class="w-full" style="display: flex; justify-content: center; align-items: center; margin-bottom: 20px;">
            <!-- <button onclick="xlsDownload();" id="download" class="mr-4 bg-gradient-to-br from-RFM-Pink to-RFM-Orange hover:text-RFM-Black border border-transparent rounded-md py-2 px-4 flex items-center justify-center text-base font-medium text-white hover:bg-RFM-Black focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-indigo-500">Download xslx RFM Overview</button> -->
            <button onclick="csvDownload();" id="download" class="mr-4 bg-gradient-to-br from-RFM-Pink to-RFM-Orange hover:text-RFM-Black border border-transparent rounded-md py-2 px-4 flex items-center justify-center text-base font-medium text-gray-200 hover:bg-RFM-Black">Download RFM Overview</button>
            </div>
            <!-- <script>
                function xlsDownload()
                {
                     // Convert to xlsx
                    var createXLSLFormatObj = [];

                    /* XLS Head Columns */
                    var xlsHeader = ["customer_id", "recency", "frequency", "monetary", "recency_score", "frequency_score", "monetary_score", "rfm_score", "segment"];

                    /* XLS Rows Data */
                    var xlsRows = Object.values(list);


                    createXLSLFormatObj.push(xlsHeader);
                    $.each(xlsRows, function(index, value) {
                        var innerRowData = [];
                        $("tbody").append('<tr><td>' + value.EmployeeID + '</td><td>' + value.FullName + '</td></tr>');
                        $.each(value, function(ind, val) {

                            innerRowData.push(val);
                        });
                        createXLSLFormatObj.push(innerRowData);
                    });


                    /* File Name */
                    var filename = "RFM_Export.xlsx";

                    /* Sheet Name */
                    var ws_name = "RFM Results";

                    if (typeof console !== 'undefined') console.log(new Date());
                    var wb = XLSX.utils.book_new(),
                        ws = XLSX.utils.aoa_to_sheet(createXLSLFormatObj);

                    /* Add worksheet to workbook */
                    XLSX.utils.book_append_sheet(wb, ws, ws_name);

                    /* Write workbook and Download */
                    if (typeof console !== 'undefined') console.log(new Date());
                    XLSX.writeFile(wb, filename);
                    if (typeof console !== 'undefined') console.log(new Date());
                }
            </script> -->


            <script>
                // Convert to csv
                function csvDownload() {
                    const csv = $.csv.fromObjects(list);

                // Download file as csv function
                const downloadBlobAsFile = function(csv, filename){
                    var downloadLink = document.createElement("a");
                    var blob = new Blob([csv], { type: 'text/csv' });
                    var url = URL.createObjectURL(blob);
                    downloadLink.href = url;
                    downloadLink.download = filename;
                    document.body.appendChild(downloadLink);
                    downloadLink.click();
                    document.body.removeChild(downloadLink);
                }

                // Download csv file
                downloadBlobAsFile(csv, 'RFM_Export.csv');
                }
          </script>
            <div class="flex flex-row flex-wrap flex-grow mt-2">
                <div class="w-full p-3">
                    <!--Graph Card-->
                    <div class="p-0.5 bg-gradient-to-tr from-RFM-Cyan to-RFM-Orange rounded shadow">
                    <div class="bg-RFM-Black">
                        <div class="p-5">
                            <canvas id="chartjs-7" class="chartjs" width="undefined" height="undefined"></canvas>
                            <script>
                           
                            // setup 
                            const data = {
                            datasets: [{
                                label: 'RFM Results',
                                data: 
                                                        array
                                                    ,
                                                    backgroundColor: [
                                                        'rgba(241, 0, 81, 0.2)'
                                                        ],
                                                        borderColor: [
                                                        'rgba(241, 0, 81, 1)'
                                                        ],
                                                        borderWidth: 1
                                                    }]
                            };

                            // config 
                            const config = {
                            type: 'bubble',
                            data,
                            options: {
                                plugins: {
                                    tooltip: {
                                        callbacks: {
                                            label: (context) => {
                                                console.log(context)
                                                return `Cleint ID: ${context.raw.cleintID},  ${context.raw.cleintStatus}`
                                            }
                                        }
                                    }
                                },
                                scales: {
                                y: {
                                    beginAtZero: true
                                }
                                }
                            }
                            };

                            // render init block
                            const myChart = new Chart(
                            document.getElementById('chartjs-7'),
                            config
                            );
                            </script>
                        </div>
                    </div>
                        </div>
                    <!--/Graph Card-->
                </div>

               
               


                <div class="w-full p-3">
                    <!--Graph Card-->
                    
                    <div class="p-0.5 bg-gradient-to-tr from-RFM-Cyan to-RFM-Orange rounded shadow">
                    <div class="bg-RFM-Black">
                        
                        <div class="p-5">
                            <canvas id="chartjs-4" class="chartjs" width="undefined" height="undefined"></canvas>
                            <script>
                                
                                var res = array.reduce(function(obj, v) {
                                obj[v.cleintStatus] = (obj[v.cleintStatus] || 0) + 1;
                                return obj;
                                }, {})
                                new Chart(document.getElementById("chartjs-4"), {
                                    "type": "bar",
                                    "data": {
                                        "labels": Object.keys(res),
                                        "datasets": [{
                                            "label": "Cleints",
                                            "data": Object.values(res),
                                            "backgroundColor": ["rgba(241, 0, 81, 0.2)"],
                                            "borderColor": ['rgba(241, 0, 81, 1)'],
                                            "borderWidth": 1
                                        }]
                                    },
                                    "options": {
                                    "plugins": {
                                        "title": {
                                            "display": true,
                                            "text": 'Segments of all cleints'
                                        }
                                    }
                                }
                                });
                            </script>
                        </div>
                    </div>
                    </div>
                    <!--/Graph Card-->
                </div>
            </div>
								
			<!--/ Console Content-->
					
		</div>
		

	</div> 
	<!--/container-->

    
			<!--Divider-->
			<hr class="border-b-2 border-RFM-Orange my-8 mx-4">
           
   
        <footer class="bg-RFM-Black">	
		    <div class="container max-w-md mx-auto flex py-8">

			<div class="w-full mx-auto flex flex-wrap">
				<div class="flex w-full md:w-1/2 ">
					<div class="px-8">
						<h3 class="block text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-br from-RFM-Pink to-RFM-Orange">About</h3>
						<p class="mt-1 block text-base text-gray-300">
                        Designers en developers weten wij altijd het maximale uit de e-commerce van onze klanten te halen.
						</p>
					</div>
				</div>
				
				<div class="flex w-full md:w-1/2">
					<div class="px-8">
					<h3 class="block text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-br from-RFM-Pink to-RFM-Orange">Social</h3>
						<ul class="flex" style="justify-content: center; grid-gap: 20px;">
						  <li>
							<a class="mt-1 block text-base text-gray-300" href="https://nl.linkedin.com/company/global-marketing-unity" rel="nofollow noopener noreferrer" target="_blank" title="Volg ons op: LinkedIn"><p><i class="fab fa-linkedin fa-spin" style="font-size:30px"></i></p></a>
						  </li>
						  <li>
							<a class="mt-1 block text-base text-gray-300" href="https://www.instagram.com/gmu_online/" rel="nofollow noopener noreferrer" target="_blank" title="Volg ons op: Instagram"><p><i class="fab fa-instagram fa-spin" style="font-size:30px"></i></p></a>
						  </li>
							<li>
							<a class="mt-1 block text-base text-gray-300" href="https://www.facebook.com/GMU.online/" rel="nofollow noopener noreferrer" target="_blank" title="Volg ons op: Facebook"><p><i class="fab fa-facebook fa-spin" style="font-size:30px"></i></p></a>
						  </li>
						</ul>
					</div>
				</div>
			</div>
        
            <ul>
                <li class="no-childnodes"><a fab="" href="https://nl.linkedin.com/company/global-marketing-unity" rel="nofollow noopener noreferrer" target="_blank" title="Volg ons op: LinkedIn"></a></li><li class="no-childnodes"><a fab="" href="https://www.instagram.com/gmu_online/" rel="nofollow noopener noreferrer" target="_blank" title="Volg ons op: Instagram"></a></li><li class="no-childnodes"><a fab="" href="https://www.facebook.com/GMU.online/" rel="nofollow noopener noreferrer" target="_blank" title="Volg ons op: Facebook"></a></li></ul>
        </div>
	    </footer>
 

<script>
	
	
	/*Toggle dropdown list*/
	/*https://gist.github.com/slavapas/593e8e50cf4cc16ac972afcbad4f70c8*/

	var userMenuDiv = document.getElementById("userMenu");
	var userMenu = document.getElementById("userButton");
	
	var navMenuDiv = document.getElementById("nav-content");
	var navMenu = document.getElementById("nav-toggle");
	
	document.onclick = check;

	function check(e){
	  var target = (e && e.target) || (event && event.srcElement);

	  //User Menu
	  if (!checkParent(target, userMenuDiv)) {
		// click NOT on the menu
		if (checkParent(target, userMenu)) {
		  // click on the link
		  if (userMenuDiv.classList.contains("invisible")) {
			userMenuDiv.classList.remove("invisible");
		  } else {userMenuDiv.classList.add("invisible");}
		} else {
		  // click both outside link and outside menu, hide menu
		  userMenuDiv.classList.add("invisible");
		}
	  }
	  
	  //Nav Menu
	  if (!checkParent(target, navMenuDiv)) {
		// click NOT on the menu
		if (checkParent(target, navMenu)) {
		  // click on the link
		  if (navMenuDiv.classList.contains("hidden")) {
			navMenuDiv.classList.remove("hidden");
		  } else {navMenuDiv.classList.add("hidden");}
		} else {
		  // click both outside link and outside menu, hide menu
		  navMenuDiv.classList.add("hidden");
		}
	  }
	  
	}

	function checkParent(t, elm) {
	  while(t.parentNode) {
		if( t == elm ) {return true;}
		t = t.parentNode;
	  }
	  return false;
	}


</script>

</body>
</html>

      
@endsection
