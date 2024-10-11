<section class="vbox">
    <section>
        <section class="hbox stretch"> 
            <aside class="bg-dark lter aside-md hidden-print hidden-xs" id="nav">
                <section class="vbox">
                    <section class="w-f scrollable">
                        <div class="slim-scroll" data-height="auto" data-disable-fade-out="true" data-distance="0"
                            data-size="5px" data-color="#333333"> 
                            <nav class="nav-primary hidden-xs">
                                <ul class="nav">
                                    <li> <a href="{{ route('dashboard') }}"> <i class="fa fa-pencil icon"> <b
                                                    class="bg-primary"></b> </i> <span>Dashboard</span> </a> </li>
                                    <li class="active">
                                        <a href="{{ route('dashboard') }}" class="active">
                                            <i class="fa fa-dashboard icon"> <b class="bg-danger"></b> </i>
                                            <span class="pull-right">
                                                <i class="fa fa-angle-down text"></i> <i
                                                    class="fa fa-angle-up text-active"></i> </span>
                                            <span>Employees Info</span> </a>
                                        <ul class="nav lt">
                                            <li class="active"> <a href="{{ route('addnewemployee') }}" class="active"> <i
                                                        class="fa fa-angle-right"></i> <span><b>Add New Employees</b></span>
                                                </a> </li>

                                            <li class="active"> <a href="{{ route('totalemployee') }}"> <i class="fa fa-angle-right"></i>
                                                    <span><b>Total Employees</b></span> </a> </li>
                                        </ul>
                                    </li>
                                    <li class="active">
                                        <a href="" class="active">
                                                <i class="fa fa-building icon">
                                                
                                                 <b class="bg-info"></b> </i>
                                            <span class="pull-right">
                                                <i class="fa fa-angle-down text"></i> <i
                                                    class="fa fa-angle-up text-active"></i>
                                                 </span>
                                            <span>Office</span> </a>
                                        <ul class="nav lt">
                                            <li class="active"> <a href="{{ route('mobiledeveloper') }}" class="active"> <i
                                                        class="fa fa-angle-right"></i> <span><b>Mobile Developers</b></span>
                                                </a> </li>
                                            <li class="active"> <a href="{{ route('developersviewtable') }}" class="active"> <i
                                                        class="fa fa-angle-right"></i> <span><b>View Mobile Developers</b></span>
                                                </a> </li>
                                            
                                            <li class="active"> <a href="" class="active"> <i
                                                        class="fa fa-angle-right"></i> <span><b>Web Developers</b></span>
                                                </a> </li>
                                        </ul>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </section>
                </section>    
            </aside>
            
           