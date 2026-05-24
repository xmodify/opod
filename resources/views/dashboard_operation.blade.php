@extends('layouts.app')

@section('title', 'Dashboard | YSOPOD')

<style>
  /* === STUNNING HOSPITAL CARD === */
  .hosp-op-card {
    backdrop-filter: blur(10px);
    border-radius: 20px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.04);
    transition: all 0.3s ease-in-out;
  }
  .hosp-op-card:hover {
    transform: translateY(-5px);
  }
  .hosp-op-icon {
    width: 50px;
    height: 50px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .hosp-op-number {
    font-size: 2.5rem;
    font-weight: 800;
  }
</style>

@section('content')

  <!-- HERO -->
  <header class="py-4">
    <div class="container-fluid">      
        <div class="row g-4 align-items-center">
          <div class="col-lg-9">          
            <h4 class="text-success mb-2"><strong>Yasothon One Province One Data : YSOPOD</strong></h4>          
          </div>
          <div class="col-lg-3 d-flex justify-content-lg-end">
            <span class="text-secondary my-1">
                วันที่ {{ \Carbon\Carbon::now()->locale('th')->isoFormat('D MMM YYYY เวลา H:mm') }} น.&nbsp;&nbsp;
            </span>
            <button type="button" class="btn btn-sm btn-outline-success" onclick="location.reload();">
              <i class="bi bi-arrow-clockwise"></i> โหลดใหม่
            </button>
          </div>
        </div>
    </div>
  </header>

  @php
    $fmtInt = fn($n) => number_format((int)($n ?? 0));
    $colorSchemes = [
        [
            'bg' => 'linear-gradient(135deg, rgba(13, 110, 253, 0.08), rgba(13, 110, 253, 0.02))',
            'border' => 'rgba(13, 110, 253, 0.22)',
            'icon_bg' => 'rgba(13, 110, 253, 0.12)',
            'icon_color' => '#0d6efd',
            'num_color' => '#0b5ed7',
            'hover_shadow' => '0 12px 30px rgba(13, 110, 253, 0.18)'
        ],
        [
            'bg' => 'linear-gradient(135deg, rgba(24, 165, 115, 0.08), rgba(24, 165, 115, 0.02))',
            'border' => 'rgba(24, 165, 115, 0.22)',
            'icon_bg' => 'rgba(24, 165, 115, 0.12)',
            'icon_color' => '#18a573',
            'num_color' => '#158058',
            'hover_shadow' => '0 12px 30px rgba(24, 165, 115, 0.18)'
        ],
        [
            'bg' => 'linear-gradient(135deg, rgba(217, 70, 239, 0.08), rgba(217, 70, 239, 0.02))',
            'border' => 'rgba(217, 70, 239, 0.22)',
            'icon_bg' => 'rgba(217, 70, 239, 0.12)',
            'icon_color' => '#d946ef',
            'num_color' => '#c026d3',
            'hover_shadow' => '0 12px 30px rgba(217, 70, 239, 0.18)'
        ],
        [
            'bg' => 'linear-gradient(135deg, rgba(249, 115, 22, 0.08), rgba(249, 115, 22, 0.02))',
            'border' => 'rgba(249, 115, 22, 0.22)',
            'icon_bg' => 'rgba(249, 115, 22, 0.12)',
            'icon_color' => '#f97316',
            'num_color' => '#ea580c',
            'hover_shadow' => '0 12px 30px rgba(249, 115, 22, 0.18)'
        ],
        [
            'bg' => 'linear-gradient(135deg, rgba(99, 102, 241, 0.08), rgba(99, 102, 241, 0.02))',
            'border' => 'rgba(99, 102, 241, 0.22)',
            'icon_bg' => 'rgba(99, 102, 241, 0.12)',
            'icon_color' => '#6366f1',
            'num_color' => '#4f46e5',
            'hover_shadow' => '0 12px 30px rgba(99, 102, 241, 0.18)'
        ],
        [
            'bg' => 'linear-gradient(135deg, rgba(236, 72, 153, 0.08), rgba(236, 72, 153, 0.02))',
            'border' => 'rgba(236, 72, 153, 0.22)',
            'icon_bg' => 'rgba(236, 72, 153, 0.12)',
            'icon_color' => '#ec4899',
            'num_color' => '#db2777',
            'hover_shadow' => '0 12px 30px rgba(236, 72, 153, 0.18)'
        ],
        [
            'bg' => 'linear-gradient(135deg, rgba(20, 184, 166, 0.08), rgba(20, 184, 166, 0.02))',
            'border' => 'rgba(20, 184, 166, 0.22)',
            'icon_bg' => 'rgba(20, 184, 166, 0.12)',
            'icon_color' => '#14b8a6',
            'num_color' => '#0d9488',
            'hover_shadow' => '0 12px 30px rgba(20, 184, 166, 0.18)'
        ],
        [
            'bg' => 'linear-gradient(135deg, rgba(245, 158, 11, 0.08), rgba(245, 158, 11, 0.02))',
            'border' => 'rgba(245, 158, 11, 0.22)',
            'icon_bg' => 'rgba(245, 158, 11, 0.12)',
            'icon_color' => '#f59e0b',
            'num_color' => '#d97706',
            'hover_shadow' => '0 12px 30px rgba(245, 158, 11, 0.18)'
        ],
        [
            'bg' => 'linear-gradient(135deg, rgba(139, 92, 246, 0.08), rgba(139, 92, 246, 0.02))',
            'border' => 'rgba(139, 92, 246, 0.22)',
            'icon_bg' => 'rgba(139, 92, 246, 0.12)',
            'icon_color' => '#8b5cf6',
            'num_color' => '#7c3aed',
            'hover_shadow' => '0 12px 30px rgba(139, 92, 246, 0.18)'
        ],
    ];
  @endphp

  <!-- ส่วนแสดงการ์ดแยก รพ (วันนี้) -->
  <section id="hospitals-today" class="pb-4">
    <div class="container-fluid">
      <h5 class="fw-bold mb-3 text-primary d-flex align-items-center">
        <i class="fa-solid fa-kit-medical me-2 text-danger"></i> จำนวนผู้ป่วยผ่าตัด วันนี้แยกตามโรงพยาบาล
      </h5>
      <div class="row g-4">
        @foreach($hospitalSummary as $h)
          @php
            $color = $colorSchemes[$loop->index % count($colorSchemes)];
          @endphp
          <style>
            .hosp-op-card-{{ $h->hospcode }}:hover {
              box-shadow: {{ $color['hover_shadow'] }} !important;
              border-color: {{ $color['icon_color'] }} !important;
            }
          </style>
          <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
            <div class="card hosp-op-card hosp-op-card-{{ $h->hospcode }} p-3 h-100" style="background: {{ $color['bg'] }}; border: 1px solid {{ $color['border'] }};">
              <div class="d-flex align-items-center justify-content-between mb-3">
                <div>
                  <h6 class="fw-bold mb-0" style="font-weight: 700; color: {{ $color['num_color'] }}; line-height: 1.4;">
                    {{ $h->hospname }}
                    <span class="ms-1" style="font-size: 0.75rem; font-weight: 500; color: {{ $color['icon_color'] }}; opacity: 0.75;">({{ $h->hospcode }})</span>
                  </h6>
                </div>
                <div class="hosp-op-icon" style="background-color: {{ $color['icon_bg'] }}; color: {{ $color['icon_color'] }};">
                  <i class="fa-solid fa-kit-medical fs-4"></i>
                </div>
              </div>
              <div class="d-flex align-items-baseline justify-content-between mt-auto">
                <span class="text-secondary small" style="font-weight: 500;">ผ่าตัดวันนี้</span>
                <span class="hosp-op-number" style="color: {{ $color['num_color'] }};">{{ $fmtInt($h->visit_operation) }}</span>
              </div>
              <hr class="my-2 opacity-50">
              <span class="text-muted small" style="font-size: 0.75rem;">
                <i class="bi bi-clock-history"></i> อัปเดต: {{ \Carbon\Carbon::parse($h->last_updated_at)->locale('th')->isoFormat('D MMM YYYY H:mm') }} น.
              </span>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  <br>
  <hr>

  {{-- เลือกปีงบประมาณ ----------------------------------------------------------------------------------------------------------}}
  <section id="summary" class="pb-2">
      <div class="container-fluid">
        <form method="POST" action="{{ url('web/operation') }}" enctype="multipart/form-data">
        @csrf
          <div class="row g-4 align-items-center">
            <div class="col-lg-9">          
              <h6 class="text-success mb-2"><strong></strong></h6>          
            </div>
            <div class="col-lg-3 d-flex justify-content-lg-end">
              <div class="d-flex align-items-center gap-2">
                <select class="form-select" name="budget_year">
                  @foreach ($budget_year_select as $row)
                    <option value="{{ $row->LEAVE_YEAR_ID }}"
                      {{ (int)$budget_year === (int)$row->LEAVE_YEAR_ID ? 'selected' : '' }}>
                      {{ $row->LEAVE_YEAR_NAME }}
                    </option>
                  @endforeach
                </select>
                <button type="submit" class="btn btn-primary">{{ __('ค้นหา') }}</button>
              </div>
            </div>
          </div>
        </form>
      </div>
  </section>

  {{-- ข้อมูลบริการรายเดือน ----------------------------------------------------------------------------------------------------------}}
  <section id="hospital" class="pb-2">
    <div class="container-fluid">
    
      <!-- NAV PILLS -->
      <ul class="nav nav-pills overflow-auto flex-nowrap" id="hospPills" role="tablist">
        @foreach($hospitalData as $hospcode => $data)
        <li class="nav-item me-2" role="presentation">
          <button class="nav-link {{ $loop->first ? 'active' : '' }}" id="tab-{{ $hospcode }}" data-bs-toggle="pill" data-bs-target="#pane-{{ $hospcode }}" type="button" role="tab" aria-controls="pane-{{ $hospcode }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}">
            {{ $data['hospname'] }}
          </button>
        </li>
        @endforeach
      </ul>

      <!-- TAB PANES -->
      <div class="tab-content mt-3" id="hospPillsContent">
        @foreach($hospitalData as $hospcode => $data)
        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="pane-{{ $hospcode }}" role="tabpanel" aria-labelledby="tab-{{ $hospcode }}" tabindex="0">          
          <!-- Operation -->
          <div class="glass p-3">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <h6>[{{ $hospcode }}] ข้อมูลผู้ป่วยผ่าตัด {{ $data['hospname'] }} ปีงบประมาณ {{$budget_year}}</h6>
              <span class="text-secondary small">Update {{ $data['update_at'] }}</span>
            </div>
            
            <div class="row">
              <div class="col-xl-6 mb-3">
                <div class="table-responsive">
                  <table id="table{{ $hospcode }}_op" class="table table-bordered table-striped my-3" width="100%">
                    <thead class="table-light">
                      <tr class="table-opd">
                          <th class="text-center" width="20%">เดือน</th>
                          <th class="text-center">จำนวนครั้งผ่าตัด (ราย)</th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach($data['operation'] as $row)
                      <tr>
                        <td class="text-center">{{ $row->month }}</td>
                        <td class="text-end fw-bold text-primary">{{ number_format($row->visit_operation) }}</td>
                      </tr>
                    @endforeach
                      <tr class="table-secondary fw-bold">
                        <td class="text-end">รวม</td>
                        <td class="text-end text-danger">{{ number_format($data['operation']->sum('visit_operation')) }}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>

              <!-- กราฟแนวโน้มผ่าตัด -->
              <div class="col-xl-6 mb-3">
                <div class="card shadow-sm border-0 h-100">
                  <div class="card-body">
                    <h6 class="text-center text-primary mb-3">
                      📈 แนวโน้มจำนวนครั้งผ่าตัดรายเดือน
                    </h6>
                    <div id="chart_op_{{ $hospcode }}"></div>
                  </div>
                </div>
              </div>
            </div>

          </div>    
        </div>
        @endforeach
      </div>
    </div>
  </section>

@endsection

@push('scripts')
  <script>
    $(function () {
      @foreach($hospitalData as $hospcode => $data)
        $('#table{{ $hospcode }}_op').DataTable({
          dom: '<"d-flex justify-content-end mb-2"B>rt',
          buttons: [
            {
              extend: 'excelHtml5',
              text: '<i class="bi bi-file-earmark-excel"></i> ส่งออก Excel',
              className: 'btn btn-success btn-sm',
              title: 'ข้อมูลผู้ป่วยผ่าตัด {{ $data['hospname'] }} {{ $budget_year ?? "" }}'
            }
          ],
          ordering: false,
          paging: false,
          info: false,
          lengthChange: false,
          language: { search: "ค้นหา:" }
        });
      @endforeach
    });
  </script>
@endpush

<!-- script กราฟ  ---------------------------------------------------------------------------------------->
<script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
<script>
  document.addEventListener("DOMContentLoaded", () => {
    @foreach($hospitalData as $hospcode => $data)
      @php
        $months = $data['operation']->pluck('month');
        $op_data = $data['operation']->pluck('visit_operation');
      @endphp

      (function() {
        const months = {!! json_encode($months) !!};
        const opData = {!! json_encode($op_data) !!};

        new ApexCharts(document.querySelector("#chart_op_{{ $hospcode }}"), {
          series: [{ name: 'จำนวนผ่าตัด', data: opData }],
          chart: { height: 300, type: 'area', toolbar: { show: false } },
          colors: ['#2e7d32'],
          stroke: { curve: 'smooth', width: 3 },
          xaxis: { categories: months },
          yaxis: { labels: { formatter: val => Math.round(val) } },
          dataLabels: { enabled: true }
        }).render();
      })();
    @endforeach
  });
</script>
