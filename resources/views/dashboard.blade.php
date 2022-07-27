@extends('layouts.app')

@section('content')

<div class="row mb-lg-7">

    <div class="col-xl-9">
        <div class="card card-calendar">
        <div class="card-body p-3">
            <div class="calendar" data-bs-toggle="calendar" id="calendar"></div>
        </div>
        </div>
    </div>

    <div class="col-xl-3">
        <div class="row">
        <div class="col-xl-12 col-md-6 mt-xl-0 mt-4">
            <div class="card">
            <div class="card-header p-3 pb-0">
                <h6 class="mb-0">Next events</h6>
            </div>
            <div class="card-body border-radius-lg p-3">
                <div class="d-flex">
                <div>
                    <div class="icon icon-shape bg-danger-soft shadow text-center border-radius-md shadow-none">
                    <i class="ni ni-money-coins text-lg text-danger text-gradient opacity-10" aria-hidden="true"></i>
                    </div>
                </div>
                <div class="ms-3">
                    <div class="numbers">
                    <h6 class="mb-1 text-dark text-sm">Cyber Week</h6>
                    <span class="text-sm">27 March 2021, at 12:30 PM</span>
                    </div>
                </div>
                </div>
                <div class="d-flex mt-4">
                <div>
                    <div class="icon icon-shape bg-primary-soft shadow text-center border-radius-md shadow-none">
                    <i class="ni ni-bell-55 text-lg text-primary text-gradient opacity-10" aria-hidden="true"></i>
                    </div>
                </div>
                <div class="ms-3">
                    <div class="numbers">
                    <h6 class="mb-1 text-dark text-sm">Meeting with Marry</h6>
                    <span class="text-sm">24 March 2021, at 10:00 PM</span>
                    </div>
                </div>
                </div>
                <div class="d-flex mt-4">
                <div>
                    <div class="icon icon-shape bg-success-soft shadow text-center border-radius-md shadow-none">
                    <i class="ni ni-books text-lg text-success text-gradient opacity-10" aria-hidden="true"></i>
                    </div>
                </div>
                <div class="ms-3">
                    <div class="numbers">
                    <h6 class="mb-1 text-dark text-sm">Book Deposit Hall</h6>
                    <span class="text-sm">25 March 2021, at 9:30 AM</span>
                    </div>
                </div>
                </div>
                <div class="d-flex mt-4">
                <div>
                    <div class="icon icon-shape bg-warning-soft shadow text-center border-radius-md shadow-none">
                    <i class="ni ni-delivery-fast text-lg text-warning text-gradient opacity-10" aria-hidden="true"></i>
                    </div>
                </div>
                <div class="ms-3">
                    <div class="numbers">
                    <h6 class="mb-1 text-dark text-sm">Shipment Deal UK</h6>
                    <span class="text-sm">25 March 2021, at 2:00 PM</span>
                    </div>
                </div>
                </div>
                <div class="d-flex mt-4">
                <div>
                    <div class="icon icon-shape bg-info-soft shadow text-center border-radius-md shadow-none">
                    <i class="ni ni-palette text-lg text-info text-gradient opacity-10" aria-hidden="true"></i>
                    </div>
                </div>
                <div class="ms-3">
                    <div class="numbers">
                    <h6 class="mb-1 text-dark text-sm">Verify Dashboard Color Palette</h6>
                    <span class="text-sm">26 March 2021, at 9:00 AM</span>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
</div>
@endsection

@section('js_custom')
    <script !src="">
    var calendar = new FullCalendar.Calendar(document.getElementById("calendar"), {
      contentHeight: 'auto',
      initialView: "dayGridMonth",
      headerToolbar: {
        start: 'title', // will normally be on the left. if RTL, will be on the right
        center: '',
        end: 'today prev,next' // will normally be on the right. if RTL, will be on the left
      },
      selectable: true,
      editable: true,
      initialDate: '2021-12-01',
      events: [{
          title: 'Call with Dave',
          start: '2021-11-18',
          end: '2021-11-18',
          className: 'bg-gradient-danger'
        },

        {
          title: 'Lunch meeting',
          start: '2021-11-21',
          end: '2021-11-22',
          className: 'bg-gradient-warning'
        },

        {
          title: 'All day conference',
          start: '2021-11-29',
          end: '2021-11-29',
          className: 'bg-gradient-success'
        },

        {
          title: 'Meeting with Mary',
          start: '2021-12-01',
          end: '2021-12-01',
          className: 'bg-gradient-info'
        },

        {
          title: 'Winter Hackaton',
          start: '2021-12-03',
          end: '2021-12-03',
          className: 'bg-gradient-danger'
        },

        {
          title: 'Digital event',
          start: '2021-12-07',
          end: '2021-12-09',
          className: 'bg-gradient-warning'
        },

        {
          title: 'Marketing event',
          start: '2021-12-10',
          end: '2021-12-10',
          className: 'bg-gradient-primary'
        },

        {
          title: 'Dinner with Family',
          start: '2021-12-19',
          end: '2021-12-19',
          className: 'bg-gradient-danger'
        },

        {
          title: 'Black Friday',
          start: '2021-12-23',
          end: '2021-12-23',
          className: 'bg-gradient-info'
        },

        {
          title: 'Cyber Week',
          start: '2021-12-02',
          end: '2021-12-02',
          className: 'bg-gradient-warning'
        },

      ],
      views: {
        month: {
          titleFormat: {
            month: "long",
            year: "numeric"
          }
        },
        agendaWeek: {
          titleFormat: {
            month: "long",
            year: "numeric",
            day: "numeric"
          }
        },
        agendaDay: {
          titleFormat: {
            month: "short",
            year: "numeric",
            day: "numeric"
          }
        }
      },
    });

    calendar.render();

    </script>
@endsection
