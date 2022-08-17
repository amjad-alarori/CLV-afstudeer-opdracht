@extends('layouts.app')

@section('content')

<body class="bg-RFM-Black font-sans leading-normal tracking-normal">


        <nav id="header" class="bg-RFM-Black fixed w-full z-10 top-0 shadow"></nav>


		<div class="w-full container mx-auto flex flex-wrap items-center mt-0 pt-3 pb-3 md:pb-0 p-4">
			<div class="w-1/2 pl-2 md:pl-0">
            <div data-aos="fade-right" class="w-full flex-grow lg:flex lg:items-center lg:w-auto hidden lg:block mt-2 lg:mt-0 bg-RFM-Black z-20" id="nav-content">
				<ul class="list-reset lg:flex flex-1 items-center px-4 md:px-0">
					<li class="mr-6 my-2 md:my-0">
                        <a href="{{ url('/') }}" class="block py-1 md:py-3 pl-1 align-middle text-gray-300 no-underline hover:text-gray-100 border-b-2 border-gray-900  hover:border-RFM-Pink">
                            <i class="fas fa-home fa-fw mr-3"></i><span class="pb-1 md:pb-0 text-sm font-head">Home</span>
                        </a>
                    </li>
                    @if (Laratrust::hasRole('admin'))
                    @auth
					<li class="mr-6 my-2 md:my-0">
                        <a href="#"  onclick="window.location.href='/edit-users'" class="block py-1 md:py-3 pl-1 align-middle text-gray-300 no-underline hover:text-gray-100 border-b-2 border-gray-900  hover:border-RFM-Pink">
                            <i class="fas fa-tasks fa-fw mr-3"></i><span class="pb-1 md:pb-0 text-sm font-head">Edit Roles and Permissions</span>
                        </a>
                    </li>
                    @endauth
                    @endif
				</ul>
			</div>
            </div>
			<div class="w-1/2 pr-0">
				<div class="flex relative inline-block float-right p-4">
                @if (Route::has('login'))
                <div data-aos="fade-left" class="space-x-4">
                    @auth
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="w-full bg-gradient-to-br from-RFM-Pink to-RFM-Orange hover:text-RFM-Black border border-transparent rounded-md py-2 px-4 flex items-center justify-center text-base font-medium text-white hover:bg-RFM-Pink_hover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-indigo-500">Log out</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                    @endauth
                </div>
                 @endif

			</div>
		</div>




    <!--Container-->
    <div class="container w-full mx-auto">

        <div class="w-full px-4 md:px-0 md:mt-8 mb-4 text-gray-800 leading-normal">

			<!--Console Content-->

			<div class="flex flex-wrap p-6">
                <div data-aos="fade-right" data-aos-offset="300" data-aos-easing="ease-in-sine" class="w-full md:w-1/2 xl:w-1/3 p-3">
                    <!--Metric Card-->
                    <div class="p-0.5 bg-gradient-to-tr from-RFM-Cyan to-RFM-Orange rounded shadow">
                    <div class="bg-RFM-Black">
                        <div class="flex flex-row items-center">
                            <div class="flex-shrink pr-4">
                                <div class="rounded p-3"><img src="https://img.icons8.com/fluency/48/000000/money-bag-euro.png"/></div>
                            </div>
                            <div id="total_revenue" class="flex-1 text-right md:text-center p-4">
                                    <total-revenue></total-revenue>
                            </div>

                        </div>
                        </div>
                    </div>
                    <!--/Metric Card-->
                </div>

                <div data-aos="fade-down" data-aos-duration="300" class="w-full md:w-1/2 xl:w-1/3 p-3">
                    <!--Metric Card-->
                    <div class="p-0.5 bg-gradient-to-tr from-RFM-Cyan to-RFM-Orange rounded shadow">
                    <div class="bg-RFM-Black">
                        <div class="flex flex-row items-center">
                            <div class="flex-shrink pr-4">
                                <div class="rounded p-3"><img src="https://img.icons8.com/color/48/000000/group.png"/></div>
                            </div>

                            <div id="total_customers" class="flex-1 text-right md:text-center  p-4">
                                <total-customers></total-customers>
                            </div>
                        </div>
                        </div>
                    </div>
                    <!--/Metric Card-->
                </div>
                <div data-aos="fade-left" data-aos-offset="300" data-aos-easing="ease-in-sine"  class="w-full md:w-1/2 xl:w-1/3 p-3">
                    <!--Metric Card-->
                    <div class="p-0.5 bg-gradient-to-tr from-RFM-Cyan to-RFM-Orange rounded shadow">
                    <div class="bg-RFM-Black">
                        <div class="flex flex-row items-center">
                            <div class="flex-shrink pr-4">
                                <div class="rounded p-3"><img src="https://img.icons8.com/fluency/48/000000/user-engagement-male.png"/></div>
                            </div>

                            <div id="new_customers" class="flex-1 text-right md:text-center  p-4">
                                <new-customers></new-customers>
                            </div>
                        </div>
                        </div>
                    </div>
                    <!--/Metric Card-->
                </div>

            </div>
        </div>


        <form action="{{route('fileUpload')}}" method="post" enctype="multipart/form-data">
      
            @csrf
    
          
            <div class="custom-file">
                <input type="file" name="file" class="custom-file-input" id="chooseFile">
                <label class="custom-file-label" for="chooseFile">Select file</label>
            </div>
            <button type="submit" name="submit" class="btn btn-primary btn-block mt-4">
                Upload Files
            </button>
        </form>


   
  <VueFileAgent :uploadUrl="uploadUrl" v-model="fileRecords"></VueFileAgent>

  

        @if (Laratrust::hasRole(['admin', 'marketer']))
            @auth
                <div data-aos="fade-up" data-aos-anchor-placement="top-center" id="xslx">
                    <xslx-download></xslx-download>
                </div>
            @endauth
        @endif
    </div>
            <div class="flex flex-row flex-wrap flex-grow mt-2">
{{--                bubble chart--}}
                <div data-aos="zoom-out" class="w-full p-9">
                    <!--Graph Card-->
                    <div class="p-0.5 bg-gradient-to-tr from-RFM-Cyan to-RFM-Orange rounded shadow">
                         <div class="bg-RFM-Black">
                                 <div class="p-5">
                                     <!-- <div id="chartdiv"></div> -->
                                     <div id="bubble">
                                         <bubble-chart></bubble-chart>
                                     </div>

                                </div>
                        </div>
                    </div>
                    <!--/Graph Card-->
                </div>

                <div data-aos="zoom-out" class="w-full p-9">
                    <!--Graph Card-->
                    <div class="p-0.5 bg-gradient-to-tr from-RFM-Cyan to-RFM-Orange rounded shadow">
                         <div class="bg-RFM-Black">
                                 <div class="p-5">
                                     <div id="bar_chart">
                                         <bar-chart></bar-chart>
                                     </div>

                                 </div>
                         </div>

                    </div>
                    <!--Divider-->
                    <hr class="border-b-2 border-RFM-Orange my-8">


                    <footer class="bg-RFM-Black">
                        <div class="float-left container max-w-md mx-auto flex py-8">

                            <div data-aos="fade-right" data-aos-anchor="#example-anchor" data-aos-offset="900" data-aos-duration="900" class="float-left mx-auto flex flex-wrap">
                                <div class="float-left flex w-full md:w-1/2 ">
                                    <div class="float-left">
                                        <h3 class="block text-2xl font-head font-bold text-transparent bg-clip-text bg-gradient-to-br from-RFM-Pink to-RFM-Orange">About</h3>
                                        <p class="mt-1 block font-sans text-base text-gray-300">
                                            Designers en developers weten wij altijd het maximale uit de e-commerce van onze klanten te halen.
                                        </p>
                                    </div>
                                </div>

                                <div class="flex w-full md:w-1/2">
                                    <div class="px-8">
                                        <h3 class="block text-2xl font-sans font-bold text-transparent bg-clip-text bg-gradient-to-br from-RFM-Pink to-RFM-Orange">Social</h3>
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
                    <!--/Graph Card-->

                </div>

            </div>

        <!--/ Console Content-->



    </div>


        </div>
        <!--/container-->






</body>
    </html>


@endsection

