@extends('layout.admin.master')
@section('lib-css')
@endsection
@push('custom-css')
    <style type="text/css">

    </style>
@endpush
@section('content')
    <main class="c-main">
        <div class="container-fluid">
            <div class="fade-in">
                <div id="dashboard">
                    <div class="row">
                        <div class="col-sm-6 col-lg-3">
                            <div class="card text-white bg-gradient-primary">
                                <div class="card-body card-body pb-0 d-flex justify-content-between align-items-start">
                                    <div>
                                        <div class="text-value-lg">@{{ total_submission }}</div>
                                        <div>Total Submission</div>
                                    </div>
                                    <div class="btn-group">
                                        <button class="btn btn-transparent" type="button">
                                            <svg class="c-icon">
                                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-settings"></use>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                                    <canvas class="chart" id="card-chart1" height="70"></canvas>
                                </div>
                            </div>
                        </div>
                        <!-- /.col-->
                        <div class="col-sm-6 col-lg-3">
                            <div class="card text-white bg-gradient-info">
                                <div class="card-body card-body pb-0 d-flex justify-content-between align-items-start">
                                    <div>
                                        <div class="text-value-lg">@{{ total_approved }}</div>
                                        <div>Total Approved</div>
                                    </div>
                                    <div class="btn-group">
                                        <button class="btn btn-transparent" type="button">
                                            <svg class="c-icon">
                                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-settings"></use>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                                    <canvas class="chart" id="card-chart2" height="70"></canvas>
                                </div>
                            </div>
                        </div>
                        <!-- /.col-->
                        <div class="col-sm-6 col-lg-3">
                            <div class="card text-white bg-gradient-warning">
                                <div class="card-body card-body pb-0 d-flex justify-content-between align-items-start">
                                    <div>
                                        <div class="text-value-lg">@{{ total_pending }}</div>
                                        <div>Total Pending</div>
                                    </div>
                                    <div class="btn-group">
                                        <button class="btn btn-transparent" type="button">
                                            <svg class="c-icon">
                                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-settings"></use>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="c-chart-wrapper mt-3" style="height:70px;">
                                    <canvas class="chart" id="card-chart3" height="70"></canvas>
                                </div>
                            </div>
                        </div>
                        <!-- /.col-->
                        <div class="col-sm-6 col-lg-3">
                            <div class="card text-white bg-gradient-danger">
                                <div class="card-body card-body pb-0 d-flex justify-content-between align-items-start">
                                    <div>
                                        <div class="text-value-lg">@{{ total_declined }}</div>
                                        <div>Total Declined</div>
                                    </div>
                                    <div class="btn-group">
                                        <button class="btn btn-transparent" type="button">
                                            <svg class="c-icon">
                                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-settings"></use>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                                    <canvas class="chart" id="card-chart4" height="70"></canvas>
                                </div>
                            </div>
                        </div>
                        <!-- /.col-->
                    </div>
                    <!-- /.row-->
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="card-title mb-0">Application</h4>
                                    <div class="small text-muted">February 2020</div>
                                </div>
                                <div class="btn-toolbar d-none d-md-block" role="toolbar"
                                     aria-label="Toolbar with buttons">
                                    <div class="btn-group btn-group-toggle mx-3" data-toggle="buttons">
                                        <label class="btn btn-outline-secondary">
                                            <input id="option1" type="radio" name="options" autocomplete="off"> Day
                                        </label>
                                        <label class="btn btn-outline-secondary active">
                                            <input id="option2" type="radio" name="options" autocomplete="off"
                                                   checked="">
                                            Month
                                        </label>
                                        <label class="btn btn-outline-secondary">
                                            <input id="option3" type="radio" name="options" autocomplete="off"> Year
                                        </label>
                                    </div>
                                    <button class="btn btn-primary" type="button">
                                        <svg class="c-icon">
                                            <use
                                                xlink:href="vendors/@coreui/icons/svg/free.svg#cil-cloud-download"></use>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="c-chart-wrapper" style="height:300px;margin-top:40px;">
                                <canvas class="chart" id="main-chart" height="300"></canvas>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row text-center">
                                <div class="col-sm-12 col-md mb-sm-2 mb-0">
                                    <div class="text-muted">Deposit Account</div>
                                    <strong>250352 Account (52%)</strong>
                                    <div class="progress progress-xs mt-2">
                                        <div class="progress-bar bg-gradient-info" role="progressbar" style="width: 52%"
                                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md mb-sm-2 mb-0">
                                    <div class="text-muted">FDR</div>
                                    <strong>78502 Application (37%)</strong>
                                    <div class="progress progress-xs mt-2">
                                        <div class="progress-bar bg-gradient-success" role="progressbar"
                                             style="width: 37%"
                                             aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md mb-sm-2 mb-0">
                                    <div class="text-muted">Loan Account</div>
                                    <strong>22123 Application (11%)</strong>
                                    <div class="progress progress-xs mt-2">
                                        <div class="progress-bar bg-gradient-danger" role="progressbar"
                                             style="width: 11%"
                                             aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.row-->
                    <div class="card-columns cols-2">
                        <div class="card">
                            <div class="card-header">ID Verification Statistic
                                <div class="card-header-actions"><a class="card-header-action"
                                                                    href="http://www.chartjs.org"
                                                                    target="_blank"><small
                                            class="text-muted">docs</small></a></div>
                            </div>
                            <div class="card-body">
                                <div class="c-chart-wrapper">
                                    <div class="chartjs-size-monitor">
                                        <div class="chartjs-size-monitor-expand">
                                            <div class=""></div>
                                        </div>
                                        <div class="chartjs-size-monitor-shrink">
                                            <div class=""></div>
                                        </div>
                                    </div>
                                    <canvas id="canvas-2" style="display: block; width: 418px; height: 209px;"
                                            width="418"
                                            height="209" class="chartjs-render-monitor"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">Top District Wise Submission
                                <div class="card-header-actions"><a class="card-header-action"
                                                                    href="http://www.chartjs.org"
                                                                    target="_blank"><small
                                            class="text-muted">docs</small></a></div>
                            </div>
                            <div class="card-body">
                                <div class="c-chart-wrapper">
                                    <div class="chartjs-size-monitor">
                                        <div class="chartjs-size-monitor-expand">
                                            <div class=""></div>
                                        </div>
                                        <div class="chartjs-size-monitor-shrink">
                                            <div class=""></div>
                                        </div>
                                    </div>
                                    <canvas id="canvas-5" style="display: block; width: 418px; height: 209px;"
                                            width="418"
                                            height="209" class="chartjs-render-monitor"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">Top 10 Branches</div>
                                <div class="card-body">
                                    <div class="row">
                                        <table class="table table-responsive-sm table-hover table-outline mb-0">
                                            <thead class="thead-light">
                                            <tr>
                                                <th>Branch Name</th>
                                                <th>Approval Ratio</th>
                                                <th class="text-center">Total Submission</th>
                                                <th>Active Agents</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>
                                                    <div>New Market, Dhaka</div>
                                                    <div class="small text-muted"><span>New</span> | Registered: Jan 1,
                                                        2020
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="clearfix">
                                                        <div class="float-left"><strong>75%</strong></div>
                                                        <div class="float-right"><small class="text-muted">Jun 11, 2015
                                                                -
                                                                Jul 10, 2015</small></div>
                                                    </div>
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar bg-gradient-success" role="progressbar"
                                                             style="width: 75%" aria-valuenow="50" aria-valuemin="0"
                                                             aria-valuemax="100"></div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    960
                                                </td>
                                                <td>
                                                    7
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div>Gulshan, Dhaka</div>
                                                    <div class="small text-muted"><span>New</span> | Registered: Feb 12,
                                                        2020
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="clearfix">
                                                        <div class="float-left"><strong>70%</strong></div>
                                                        <div class="float-right"><small class="text-muted">Feb 12, 2020
                                                                -
                                                                Feb 30, 2020</small></div>
                                                    </div>
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar bg-gradient-info" role="progressbar"
                                                             style="width: 70%" aria-valuenow="50" aria-valuemin="0"
                                                             aria-valuemax="100"></div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    7502
                                                </td>
                                                <td>
                                                    7
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div>Dhanmondi, Dhaka</div>
                                                    <div class="small text-muted"><span>New</span> | Registered: Jan 1,
                                                        2015
                                                    </div>
                                                </td>

                                                <td>
                                                    <div class="clearfix">
                                                        <div class="float-left"><strong>65%</strong></div>
                                                        <div class="float-right"><small class="text-muted">Jun 11, 2015
                                                                -
                                                                Jul 10, 2015</small></div>
                                                    </div>
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar bg-gradient-warning" role="progressbar"
                                                             style="width: 65%" aria-valuenow="50" aria-valuemin="0"
                                                             aria-valuemax="100"></div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    6102
                                                </td>
                                                <td>
                                                    7
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div>Banani, Dhaka</div>
                                                    <div class="small text-muted"><span>New</span> | Registered: Jan 1,
                                                        2015
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="clearfix">
                                                        <div class="float-left"><strong>50%</strong></div>
                                                        <div class="float-right"><small class="text-muted">Jun 11, 2015
                                                                -
                                                                Jul 10, 2015</small></div>
                                                    </div>
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar bg-gradient-danger" role="progressbar"
                                                             style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                                                             aria-valuemax="100"></div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    75002
                                                </td>
                                                <td>
                                                    71
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div>Airport, Dhaka</div>
                                                    <div class="small text-muted"><span>Old</span> | Registered: Jan 1,
                                                        2018
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="clearfix">
                                                        <div class="float-left"><strong>50%</strong></div>
                                                        <div class="float-right"><small class="text-muted">Jun 11, 2015
                                                                -
                                                                Jul 10, 2020</small></div>
                                                    </div>
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar bg-gradient-success" role="progressbar"
                                                             style="width: 90%" aria-valuenow="50" aria-valuemin="0"
                                                             aria-valuemax="100"></div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    70052
                                                </td>
                                                <td>
                                                    157
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div>Lalbag, Dhaka</div>
                                                    <div class="small text-muted"><span>New</span> | Registered: Jan 1,
                                                        2018
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="clearfix">
                                                        <div class="float-left"><strong>30%</strong></div>
                                                        <div class="float-right"><small class="text-muted">Jun 11, 2018
                                                                -
                                                                Jul 10, 2020</small></div>
                                                    </div>
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar bg-gradient-danger" role="progressbar"
                                                             style="width: 30%" aria-valuenow="50" aria-valuemin="0"
                                                             aria-valuemax="100"></div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    7502
                                                </td>
                                                <td>
                                                    17
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div>Motejheel, Dhaka</div>
                                                    <div class="small text-muted"><span>Old</span> | Registered: Jan 1,
                                                        2015
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="clearfix">
                                                        <div class="float-left"><strong>90%</strong></div>
                                                        <div class="float-right"><small class="text-muted">Jun 11, 2015
                                                                -
                                                                Jul 10, 2015</small></div>
                                                    </div>
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar bg-gradient-success" role="progressbar"
                                                             style="width: 90%" aria-valuenow="50" aria-valuemin="0"
                                                             aria-valuemax="100"></div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    152752
                                                </td>
                                                <td>
                                                    712
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div>Baridhara, Dhaka</div>
                                                    <div class="small text-muted"><span>New</span> | Registered: Jan 1,
                                                        2020
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="clearfix">
                                                        <div class="float-left"><strong>50%</strong></div>
                                                        <div class="float-right"><small class="text-muted">Jun 11, 2015
                                                                -
                                                                Jul 10, 2015</small></div>
                                                    </div>
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar bg-gradient-warning" role="progressbar"
                                                             style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                                                             aria-valuemax="100"></div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    5554
                                                </td>
                                                <td>
                                                    5
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div>Uttara-14, Dhaka</div>
                                                    <div class="small text-muted"><span>New</span> | Registered: Jan 1,
                                                        2015
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="clearfix">
                                                        <div class="float-left"><strong>50%</strong></div>
                                                        <div class="float-right"><small class="text-muted">Jun 11, 2015
                                                                -
                                                                Jul 10, 2015</small></div>
                                                    </div>
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar bg-gradient-success" role="progressbar"
                                                             style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                                                             aria-valuemax="100"></div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    752
                                                </td>
                                                <td>
                                                    7
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div>Agergoan, Dhaka</div>
                                                    <div class="small text-muted"><span>New</span> | Registered: Feb 12,
                                                        2020
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="clearfix">
                                                        <div class="float-left"><strong>70%</strong></div>
                                                        <div class="float-right"><small class="text-muted">Feb 12, 2020
                                                                -
                                                                Feb 30, 2020</small></div>
                                                    </div>
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar bg-gradient-info" role="progressbar"
                                                             style="width: 70%" aria-valuenow="50" aria-valuemin="0"
                                                             aria-valuemax="100"></div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    7502
                                                </td>
                                                <td>
                                                    7
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div>Mirpur-10, Dhaka</div>
                                                    <div class="small text-muted"><span>New</span> | Registered: Jan 1,
                                                        2015
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="clearfix">
                                                        <div class="float-left"><strong>40%</strong></div>
                                                        <div class="float-right"><small class="text-muted">Jun 11, 2015
                                                                -
                                                                Jul 10, 2015</small></div>
                                                    </div>
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar bg-gradient-danger" role="progressbar"
                                                             style="width: 40%" aria-valuenow="50" aria-valuemin="0"
                                                             aria-valuemax="100"></div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    765552
                                                </td>
                                                <td>
                                                    322
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div>Rampura, Dhaka</div>
                                                    <div class="small text-muted"><span>Old</span> | Registered: Jan 1,
                                                        2015
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="clearfix">
                                                        <div class="float-left"><strong>90%</strong></div>
                                                        <div class="float-right"><small class="text-muted">Jun 11, 2015
                                                                -
                                                                Jul 10, 2015</small></div>
                                                    </div>
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar bg-gradient-success" role="progressbar"
                                                             style="width: 90%" aria-valuenow="50" aria-valuemin="0"
                                                             aria-valuemax="100"></div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    152752
                                                </td>
                                                <td>
                                                    712
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.col-->
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">Top 10 Agents</div>
                                <div class="card-body">
                                    <div class="row">
                                        <table class="table table-responsive-sm table-hover table-outline mb-0">
                                            <thead class="thead-light">
                                            <tr>
                                                <th class="text-center">
                                                    <svg class="c-icon">
                                                        <use
                                                            xlink:href="vendors/@coreui/icons/svg/free.svg#cil-people"></use>
                                                    </svg>
                                                </th>
                                                <th>Agent</th>
                                                <th class="text-center">Branch/Zone</th>
                                                <th>Approval Ratio</th>
                                                <th class="text-center">Total Submission</th>
                                                <th>Activity</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td class="text-center">
                                                    <div class="c-avatar"><img class="c-avatar-img"
                                                                               src="{{asset('images/agent-image/1.jpg')}}"
                                                                               alt="chaitychawdury@alarafahbank.com"><span
                                                            class="c-avatar-status bg-success"></span></div>
                                                </td>
                                                <td>
                                                    <div>Chaity Chowdury</div>
                                                    <div class="small text-muted"><span>New</span> | Registered: Jan 1,
                                                        2015
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    New Market, Dhaka
                                                </td>
                                                <td>
                                                    <div class="clearfix">
                                                        <div class="float-left"><strong>50%</strong></div>
                                                        <div class="float-right"><small class="text-muted">Jun 11, 2015
                                                                -
                                                                Jul 10, 2015</small></div>
                                                    </div>
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar bg-gradient-success" role="progressbar"
                                                             style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                                                             aria-valuemax="100"></div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    500
                                                </td>
                                                <td>
                                                    <div class="small text-muted">Last login</div>
                                                    <strong>10 sec ago</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">
                                                    <div class="c-avatar"><img class="c-avatar-img"
                                                                               src="{{asset('images/agent-image/7.jpg')}}"
                                                                               alt="subrnaahmerdshila@alarafahbank.com"><span
                                                            class="c-avatar-status bg-danger"></span></div>
                                                </td>
                                                <td>
                                                    <div>Suborna Ahmed Shila</div>
                                                    <div class="small text-muted"><span>Recurring</span> | Registered:
                                                        Jan
                                                        1, 2015
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    Mirpur-14, Dhaka
                                                </td>
                                                <td>
                                                    <div class="clearfix">
                                                        <div class="float-left"><strong>10%</strong></div>
                                                        <div class="float-right"><small class="text-muted">Jun 11, 2015
                                                                -
                                                                Jul 10, 2015</small></div>
                                                    </div>
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar bg-gradient-info" role="progressbar"
                                                             style="width: 10%" aria-valuenow="10" aria-valuemin="0"
                                                             aria-valuemax="100"></div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    150
                                                </td>
                                                <td>
                                                    <div class="small text-muted">Last login</div>
                                                    <strong>5 minutes ago</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">
                                                    <div class="c-avatar"><img class="c-avatar-img"
                                                                               src="{{asset('images/agent-image/3.jpg')}}"
                                                                               alt="jobayerhossain@alarafahbank.com"><span
                                                            class="c-avatar-status bg-warning"></span></div>
                                                </td>
                                                <td>
                                                    <div>Md Jobayer Hossain</div>
                                                    <div class="small text-muted"><span>New</span> | Registered: Jan 1,
                                                        2015
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    Motijheel,Dhaka
                                                </td>
                                                <td>
                                                    <div class="clearfix">
                                                        <div class="float-left"><strong>74%</strong></div>
                                                        <div class="float-right"><small class="text-muted">Jun 11, 2015
                                                                -
                                                                Jul 10, 2015</small></div>
                                                    </div>
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar bg-gradient-warning" role="progressbar"
                                                             style="width: 74%" aria-valuenow="74" aria-valuemin="0"
                                                             aria-valuemax="100"></div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    1200
                                                </td>
                                                <td>
                                                    <div class="small text-muted">Last login</div>
                                                    <strong>1 hour ago</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">
                                                    <div class="c-avatar"><img class="c-avatar-img"
                                                                               src="{{asset('images/agent-image/4.jpg')}}"
                                                                               alt="junayedrahmin@alarafahbank.com"><span
                                                            class="c-avatar-status bg-secondary"></span></div>
                                                </td>
                                                <td>
                                                    <div>Md Junayed Bin Rafiq</div>
                                                    <div class="small text-muted"><span>New</span> | Registered: Jan 1,
                                                        2015
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    Banani, Dhaka
                                                </td>
                                                <td>
                                                    <div class="clearfix">
                                                        <div class="float-left"><strong>98%</strong></div>
                                                        <div class="float-right"><small class="text-muted">Jun 11, 2015
                                                                -
                                                                Jul 10, 2015</small></div>
                                                    </div>
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar bg-gradient-danger" role="progressbar"
                                                             style="width: 98%" aria-valuenow="98" aria-valuemin="0"
                                                             aria-valuemax="100"></div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    2500
                                                </td>
                                                <td>
                                                    <div class="small text-muted">Last login</div>
                                                    <strong>Last month</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">
                                                    <div class="c-avatar"><img class="c-avatar-img"
                                                                               src="{{asset('images/agent-image/5.jpg')}}"
                                                                               alt="nomanhossain@alarafahbank.com"><span
                                                            class="c-avatar-status bg-success"></span></div>
                                                </td>
                                                <td>
                                                    <div>Md Noman Hossain</div>
                                                    <div class="small text-muted"><span>New</span> | Registered: Jan 1,
                                                        2015
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    Dhanmondi, Dhaka
                                                </td>
                                                <td>
                                                    <div class="clearfix">
                                                        <div class="float-left"><strong>22%</strong></div>
                                                        <div class="float-right"><small class="text-muted">Jun 11, 2015
                                                                -
                                                                Jul 10, 2015</small></div>
                                                    </div>
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar bg-gradient-info" role="progressbar"
                                                             style="width: 22%" aria-valuenow="22" aria-valuemin="0"
                                                             aria-valuemax="100"></div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    4582
                                                </td>
                                                <td>
                                                    <div class="small text-muted">Last login</div>
                                                    <strong>Last week</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">
                                                    <div class="c-avatar"><img class="c-avatar-img"
                                                                               src="{{asset('images/agent-image/6.jpg')}}"
                                                                               alt="masudmia@alarafahbank.com"><span
                                                            class="c-avatar-status bg-danger"></span></div>
                                                </td>
                                                <td>
                                                    <div>Md. Masud Mia</div>
                                                    <div class="small text-muted"><span>New</span> | Registered: Jan 1,
                                                        2015
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    Zindabazar, Sylhet
                                                </td>
                                                <td>
                                                    <div class="clearfix">
                                                        <div class="float-left"><strong>43%</strong></div>
                                                        <div class="float-right"><small class="text-muted">Jun 11, 2015
                                                                -
                                                                Jul 10, 2015</small></div>
                                                    </div>
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar bg-gradient-success" role="progressbar"
                                                             style="width: 43%" aria-valuenow="43" aria-valuemin="0"
                                                             aria-valuemax="100"></div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    7000
                                                </td>
                                                <td>
                                                    <div class="small text-muted">Last login</div>
                                                    <strong>Yesterday</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">
                                                    <div class="c-avatar"><img class="c-avatar-img"
                                                                               src="{{asset('images/agent-image/7.jpg')}}"
                                                                               alt="abdullahalmahmud@alarafahbank.com"><span
                                                            class="c-avatar-status bg-warning"></span></div>
                                                </td>
                                                <td>
                                                    <div>Abdullah Al Mahmud</div>
                                                    <div class="small text-muted"><span>New</span> | Registered: Jan 1,
                                                        2015
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    Motijheel,Dhaka
                                                </td>
                                                <td>
                                                    <div class="clearfix">
                                                        <div class="float-left"><strong>74%</strong></div>
                                                        <div class="float-right"><small class="text-muted">Jun 11, 2015
                                                                -
                                                                Jul 10, 2015</small></div>
                                                    </div>
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar bg-gradient-warning" role="progressbar"
                                                             style="width: 74%" aria-valuenow="74" aria-valuemin="0"
                                                             aria-valuemax="100"></div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    1200
                                                </td>
                                                <td>
                                                    <div class="small text-muted">Last login</div>
                                                    <strong>1 hour ago</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">
                                                    <div class="c-avatar"><img class="c-avatar-img"
                                                                               src="{{asset('images/agent-image/8.jpg')}}"
                                                                               alt="sultansalauddin@alarafahbank.com"><span
                                                            class="c-avatar-status bg-secondary"></span></div>
                                                </td>
                                                <td>
                                                    <div>Sultan Salauddin</div>
                                                    <div class="small text-muted"><span>New</span> | Registered: Jan 1,
                                                        2015
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    Banani, Dhaka
                                                </td>
                                                <td>
                                                    <div class="clearfix">
                                                        <div class="float-left"><strong>98%</strong></div>
                                                        <div class="float-right"><small class="text-muted">Jun 11, 2015
                                                                -
                                                                Jul 10, 2015</small></div>
                                                    </div>
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar bg-gradient-danger" role="progressbar"
                                                             style="width: 98%" aria-valuenow="98" aria-valuemin="0"
                                                             aria-valuemax="100"></div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    2500
                                                </td>
                                                <td>
                                                    <div class="small text-muted">Last login</div>
                                                    <strong>Last month</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">
                                                    <div class="c-avatar"><img class="c-avatar-img"
                                                                               src="{{asset('images/agent-image/9.jpg')}}"
                                                                               alt="rezafaruk@alarafahbank.com"><span
                                                            class="c-avatar-status bg-success"></span></div>
                                                </td>
                                                <td>
                                                    <div>Reza Faruk Chowdury</div>
                                                    <div class="small text-muted"><span>New</span> | Registered: Jan 1,
                                                        2015
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    Dhanmondi, Dhaka
                                                </td>
                                                <td>
                                                    <div class="clearfix">
                                                        <div class="float-left"><strong>22%</strong></div>
                                                        <div class="float-right"><small class="text-muted">Jun 11, 2015
                                                                -
                                                                Jul 10, 2015</small></div>
                                                    </div>
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar bg-gradient-info" role="progressbar"
                                                             style="width: 22%" aria-valuenow="22" aria-valuemin="0"
                                                             aria-valuemax="100"></div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    4582
                                                </td>
                                                <td>
                                                    <div class="small text-muted">Last login</div>
                                                    <strong>Last week</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">
                                                    <div class="c-avatar"><img class="c-avatar-img"
                                                                               src="{{asset('images/agent-image/10.jpg')}}"
                                                                               alt="rasulislam@alarafahbank.com"><span
                                                            class="c-avatar-status bg-danger"></span></div>
                                                </td>
                                                <td>
                                                    <div>Md. Raisul Islam</div>
                                                    <div class="small text-muted"><span>New</span> | Registered: Jan 1,
                                                        2015
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    Zindabazar, Sylhet
                                                </td>
                                                <td>
                                                    <div class="clearfix">
                                                        <div class="float-left"><strong>43%</strong></div>
                                                        <div class="float-right"><small class="text-muted">Jun 11, 2015
                                                                -
                                                                Jul 10, 2015</small></div>
                                                    </div>
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar bg-gradient-success" role="progressbar"
                                                             style="width: 43%" aria-valuenow="43" aria-valuemin="0"
                                                             aria-valuemax="100"></div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    7000
                                                </td>
                                                <td>
                                                    <div class="small text-muted">Last login</div>
                                                    <strong>Yesterday</strong>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.col-->
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('lib-js')
    <!--[if IE]><!-->
    <script src="{{asset('vendors/@coreui/icons/js/svgxuse.min.js')}}"></script>
    <!--<![endif]-->
    <script src="{{asset('vendors/@coreui/chartjs/js/coreui-chartjs.bundle.js')}}"></script>
    <script src="{{asset('js/charts.js')}}"></script>
@endsection
@push('custom-js')
    <script>
        const form_builder = new Vue({
            el: "#dashboard",
            data: {
                total_submission: 0,
                total_approved: 0,
                total_pending: 0,
                total_declined: 0,
            },
            methods: {
                ajaxCall: window.ajaxCall,
                responseProcess: window.responseProcess,
            },
            mounted() {
                this.ajaxCall('/api/v1/application/report', {}, 'get', (data, code) => {
                    if (code === 200) {
                        if (data && data.applicationReport) {
                            this.total_approved = data.applicationReport.totalApproved;
                            this.total_declined = data.applicationReport.totalDeclined;
                            this.total_pending = data.applicationReport.totalPending;
                            this.total_submission = data.applicationReport.totalSubmission;
                        }
                    }
                }, false);
                var pieChart = new Chart(document.getElementById('canvas-5'), {
                    type: 'pie',
                    data: {
                        labels: ['Dhaka', 'Chattagram', 'Barishal', 'Gazipur', 'Nilphamari', 'Othes'],
                        datasets: [{
                            data: [582320, 458242, 369542, 258452, 265842, 765240],
                            backgroundColor: [1, 2, 3, 4, 5, 6].map(el => 'rgb(' + random(255) + ',' + random(255) + ',' + random(255) + ')'),
                            hoverBackgroundColor: ['#FF6384', '#36A2EB', '#d2e80c', '#0fdcc4', '#FFF10C7A'],
                        }]
                    },
                    options: {
                        responsive: true
                    }
                });
                var barChart = new Chart(document.getElementById('canvas-2'), {
                    type: 'bar',
                    data: {
                        labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
                        datasets: [{
                            backgroundColor: [0, 1, 1, 2, 3, 4, 5, 6, 7, 8, 10, 11].map(el => 'rgba(' + random(250) + ',' + random(250) + ',' + random(255) + ',' + 0.9 + ')'),
                            borderColor: 'rgba(241,153,14,0.8)',
                            highlightFill: 'rgba(219,11,59,0.75)',
                            highlightStroke: 'rgb(16,51,224)',
                            data: [random(), random(), random(), random(), random(), random(), random(), random(), random(), random(), random(), random()]
                        }]
                    },
                    options: {
                        responsive: true,
                        legend: {
                            display: false
                        },
                        scales: {
                            xAxes: [{
                                scaleLabel: {
                                    display: true,
                                    labelString: 'Volunteer Hours',
                                },
                                gridLines: {
                                    display: false,
                                    drawBorder: false //<- set this
                                },
                            }],
                            yAxes: [{
                                gridLines: {
                                    display: true,
                                    drawBorder: true //<- set this
                                }
                            }]
                        }
                    }
                });
                var cardChart1 = new Chart(document.getElementById('card-chart1'), {
                    type: 'line',
                    data: {
                        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                        datasets: [{
                            label: 'My First dataset',
                            backgroundColor: 'transparent',
                            borderColor: 'rgba(255,255,255,.55)',
                            pointBackgroundColor: coreui.Utils.getStyle('--primary'),
                            data: [65, 59, 84, 84, 51, 55, 40]
                        }]
                    },
                    options: {
                        maintainAspectRatio: false,
                        legend: {
                            display: false
                        },
                        scales: {
                            xAxes: [{
                                gridLines: {
                                    color: 'transparent',
                                    zeroLineColor: 'transparent'
                                },
                                ticks: {
                                    fontSize: 2,
                                    fontColor: 'transparent'
                                }
                            }],
                            yAxes: [{
                                display: false,
                                ticks: {
                                    display: false,
                                    min: 35,
                                    max: 89
                                }
                            }]
                        },
                        elements: {
                            line: {
                                borderWidth: 1
                            },
                            point: {
                                radius: 4,
                                hitRadius: 10,
                                hoverRadius: 4
                            }
                        }
                    }
                }); // eslint-disable-next-line no-unused-vars

                var cardChart2 = new Chart(document.getElementById('card-chart2'), {
                    type: 'line',
                    data: {
                        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                        datasets: [{
                            label: 'My First dataset',
                            backgroundColor: 'transparent',
                            borderColor: 'rgba(255,255,255,.55)',
                            pointBackgroundColor: coreui.Utils.getStyle('--info'),
                            data: [1, 18, 9, 17, 34, 22, 11]
                        }]
                    },
                    options: {
                        maintainAspectRatio: false,
                        legend: {
                            display: false
                        },
                        scales: {
                            xAxes: [{
                                gridLines: {
                                    color: 'transparent',
                                    zeroLineColor: 'transparent'
                                },
                                ticks: {
                                    fontSize: 2,
                                    fontColor: 'transparent'
                                }
                            }],
                            yAxes: [{
                                display: false,
                                ticks: {
                                    display: false,
                                    min: -4,
                                    max: 39
                                }
                            }]
                        },
                        elements: {
                            line: {
                                tension: 0.00001,
                                borderWidth: 1
                            },
                            point: {
                                radius: 4,
                                hitRadius: 10,
                                hoverRadius: 4
                            }
                        }
                    }
                }); // eslint-disable-next-line no-unused-vars

                var cardChart3 = new Chart(document.getElementById('card-chart3'), {
                    type: 'line',
                    data: {
                        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                        datasets: [{
                            label: 'My First dataset',
                            backgroundColor: 'rgba(255,255,255,.2)',
                            borderColor: 'rgba(255,255,255,.55)',
                            data: [78, 81, 80, 45, 34, 12, 40]
                        }]
                    },
                    options: {
                        maintainAspectRatio: false,
                        legend: {
                            display: false
                        },
                        scales: {
                            xAxes: [{
                                display: false
                            }],
                            yAxes: [{
                                display: false
                            }]
                        },
                        elements: {
                            line: {
                                borderWidth: 2
                            },
                            point: {
                                radius: 0,
                                hitRadius: 10,
                                hoverRadius: 4
                            }
                        }
                    }
                }); // eslint-disable-next-line no-unused-vars

                var cardChart4 = new Chart(document.getElementById('card-chart4'), {
                    type: 'bar',
                    data: {
                        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December', 'January', 'February', 'March', 'April'],
                        datasets: [{
                            label: 'My First dataset',
                            backgroundColor: 'rgba(255,255,255,.2)',
                            borderColor: 'rgba(255,255,255,.55)',
                            data: [78, 81, 80, 45, 34, 12, 40, 85, 65, 23, 12, 98, 34, 84, 67, 82],
                            barPercentage: 0.6
                        }]
                    },
                    options: {
                        maintainAspectRatio: false,
                        legend: {
                            display: false
                        },
                        scales: {
                            xAxes: [{
                                display: false
                            }],
                            yAxes: [{
                                display: false
                            }]
                        }
                    }
                });
                var mainChart = new Chart(document.getElementById('' + 'main-chart'), {
                    type: 'line',
                    data: {
                        labels: ['S', 'S', 'M', 'T', 'W', 'T', 'F', 'S', 'S', 'M', 'T', 'W', 'T', 'F', 'S', 'S', 'M', 'T', 'W', 'T', 'F', 'S', 'S', 'M', 'T', 'W'],
                        datasets: [{
                            label: 'Deposit Account',
                            backgroundColor: coreui.Utils.hexToRgba(coreui.Utils.getStyle('--info'), 10),
                            borderColor: coreui.Utils.getStyle('--info'),
                            pointHoverBackgroundColor: '#fff',
                            borderWidth: 2,
                            data: [165, 180, 70, 69, 77, 57, 125, 165, 172, 91, 173, 138, 155, 89, 50, 161, 65, 163, 160, 103, 114, 185, 125, 196, 183, 64, 137, 95]
                        }, {
                            label: 'FDR',
                            backgroundColor: 'transparent',
                            borderColor: coreui.Utils.getStyle('--success'),
                            pointHoverBackgroundColor: '#fff',
                            borderWidth: 2,
                            data: [92, 97, 80, 100, 86, 97, 83, 98, 87, 98, 93, 83, 87, 98, 96, 84, 91, 97, 88, 86, 94, 86, 95, 91, 98, 91, 92, 80]
                        }, {
                            label: 'Loan Account',
                            backgroundColor: 'transparent',
                            borderColor: coreui.Utils.getStyle('--danger'),
                            pointHoverBackgroundColor: '#fff',
                            borderWidth: 1,
                            borderDash: [8, 5],
                            data: [65, 65, 65, 75, 65, 65, 65, 25, 65, 65, 65, 65, 80, 65, 65, 65, 65, 65, 65, 90, 65, 180, 65, 65, 65, 65, 65, 65]
                        }]
                    },
                    options: {
                        maintainAspectRatio: false,
                        legend: {
                            display: true
                        },
                        scales: {
                            xAxes: [{
                                gridLines: {
                                    drawOnChartArea: false
                                }
                            }],
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    maxTicksLimit: 5,
                                    stepSize: Math.ceil(250 / 5),
                                    max: 250
                                }
                            }]
                        },
                        elements: {
                            point: {
                                radius: 0,
                                hitRadius: 10,
                                hoverRadius: 4,
                                hoverBorderWidth: 3
                            }
                        }
                    }
                });
            },
        });
    </script>
@endpush
