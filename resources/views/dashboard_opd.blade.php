@extends('layouts.app')

@section('title', 'Dashboard OPD | ' . config('app.app_abbr', 'YSOPOD'))

@push('styles')
<style>
  /* === Table Styling === */
  .custom-table {
    border-collapse: separate !important;
    border-spacing: 0 !important;
    border-radius: 12px !important;
    overflow: hidden !important;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05) !important;
  }
  .custom-table thead th {
    font-weight: 700 !important;
    text-align: center !important;
    vertical-align: middle !important;
    padding: 10px 8px !important;
    font-size: 0.85rem !important;
  }
  .custom-table tbody td {
    padding: 8px !important;
    font-size: 0.85rem !important;
    color: #444 !important;
  }
  .custom-table tbody tr:hover {
    background-color: #f8fbff !important;
  }
  
  /* Header Color Groups */
  .th-blue { background: #e3f2fd !important; color: #0d47a1 !important; }
  .th-green { background: #e8f5e9 !important; color: #1b5e20 !important; }
  .th-orange { background: #fff3e0 !important; color: #e65100 !important; }
  .th-purple { background: #f3e5f5 !important; color: #4a148c !important; }
  .th-red { background: #ffebee !important; color: #b71c1c !important; }
  .th-cyan { background: #e0f7fa !important; color: #006064 !important; }
  .th-grey { background: #f5f5f5 !important; color: #424242 !important; }
  
  .tr-total {
    background: #f1f8ff !important;
    font-weight: 800 !important;
    border-top: 2px solid #0d47a1 !important;
  }

  .card-hover {
    transition: all 0.3s ease-in-out;
  }
  .card-hover:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
  }

  /* Theme Specific Cards (Crisp White + Left Accent) */
  .card-theme-opd {
    background: #ffffff !important;
    border: 1px solid var(--glass-bd) !important;
    border-left: 6px solid #1976d2 !important;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05) !important;
  }
  .card-theme-chart {
    background: #ffffff !important;
    border: 1px solid var(--glass-bd) !important;
    border-left: 6px solid #10b981 !important;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05) !important;
  }
  .card-theme-dent {
    background: #ffffff !important;
    border: 1px solid var(--glass-bd) !important;
    border-left: 6px solid #ab47bc !important;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05) !important;
  }
  .card-theme-phy {
    background: #ffffff !important;
    border: 1px solid var(--glass-bd) !important;
    border-left: 6px solid #ff7043 !important;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05) !important;
  }
  .card-theme-anc {
    background: #ffffff !important;
    border: 1px solid var(--glass-bd) !important;
    border-left: 6px solid #ec407a !important;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05) !important;
  }
  .card-theme-hm {
    background: #ffffff !important;
    border: 1px solid var(--glass-bd) !important;
    border-left: 6px solid #26a69a !important;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05) !important;
  }
  .card-theme-tele {
    background: #ffffff !important;
    border: 1px solid var(--glass-bd) !important;
    border-left: 6px solid #26c6da !important;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05) !important;
  }
  .card-theme-oapp {
    background: #ffffff !important;
    border: 1px solid var(--glass-bd) !important;
    border-left: 6px solid #66bb6a !important;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05) !important;
  }

  /* Minimal Style Chart Cards */
  .card.card-chart-blue {
    border-top: 4px solid #2563eb !important;
    background: #ffffff;
    box-shadow: 0 4px 15px rgba(0,0,0,0.04);
  }
  .card.card-chart-blue .card-header {
    background: transparent !important;
    border-bottom: none !important;
    color: #2563eb !important;
    padding-top: 15px !important;
    padding-bottom: 2px !important;
  }
  .card.card-chart-green {
    border-top: 4px solid #10b981 !important;
    background: #ffffff;
    box-shadow: 0 4px 15px rgba(0,0,0,0.04);
  }
  .card.card-chart-green .card-header {
    background: transparent !important;
    border-bottom: none !important;
    color: #10b981 !important;
    padding-top: 15px !important;
    padding-bottom: 2px !important;
  }
  .card.card-chart-purple {
    border-top: 4px solid #8b5cf6 !important;
    background: #ffffff;
    box-shadow: 0 4px 15px rgba(0,0,0,0.04);
  }
  .card.card-chart-purple .card-header {
    background: transparent !important;
    border-bottom: none !important;
    color: #8b5cf6 !important;
    padding-top: 15px !important;
    padding-bottom: 2px !important;
  }
</style>
@endpush

@section('content')

  <!-- HERO -->
  <header class="py-4">
    <div class="container-fluid">      
        <div class="row g-4 align-items-center">
          <div class="col-lg-7">          
            <div class="d-flex align-items-center gap-3">
              <div class="bg-success bg-opacity-10 rounded-3 p-2 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; border: 1px solid rgba(16, 185, 129, 0.2);">
                <i class="fa-solid fa-address-card fs-4 text-success"></i>
              </div>
              <div>
                <h4 class="fw-bold mb-1" style="color: #1e293b;">ข้อมูลบริการผู้ป่วยนอก (OPD)</h4>
                <p class="text-secondary small mb-0"><i class="fa-solid fa-square-poll-vertical text-green me-1"></i>{{ config('app.province_name_en', 'Yasothon') }} One Province One Data</p>
              </div>
            </div>          
          </div>
          {{-- ขวาสุด: วันที่ + ปุ่มโหลดใหม่ --}}
          <div class="col-lg-5 d-flex justify-content-lg-end align-items-center gap-3">
            <span class="text-secondary small fw-medium">
                วันที่ {{ \Carbon\Carbon::now()->locale('th')->isoFormat('D MMM YYYY เวลา H:mm') }} น.
            </span>
            <button type="button" class="btn btn-sm btn-glass-action" onclick="location.reload();">
              <i class="bi bi-arrow-clockwise"></i> โหลดใหม่
            </button>
          </div>
        </div>
    </div>
  </header>

  @php
    $fmtInt   = fn($n) => number_format((int)($n ?? 0));
    $fmtMoney = fn($n) => number_format((float)($n ?? 0), 2);
  @endphp

  <!-- SUMMARY ROW 1 (ผู้ป่วยนอกวันนี้ + กราฟแยกสิทธิ) -->
  <section id="summary-opd" class="pb-2">
    <div class="container-fluid">
      <div class="row g-3">  
        
        {{-- ผู้ป่วยนอก OPD วันนี้ --}}
        <div class="col-12 col-xl-4">
          <a href="#" data-bs-toggle="modal" data-bs-target="#VisitDetailModal" class="text-decoration-none text-dark">
            <div class="card card-theme-opd card-hover p-3 h-100">
              <!-- Header -->
              <div class="d-flex align-items-center justify-content-between mb-3">
                <h6 class="mb-0 text-primary fw-bold">ผู้ป่วยนอก OPD วันนี้</h6>
                <div class="bg-primary bg-opacity-10 rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                  <i class="bi bi-person-heart fs-4 text-primary"></i>
                </div>
              </div>
              <!-- Body Numbers -->
              <div class="d-flex justify-content-between align-items-center text-center">
                <!-- visit op -->
                <div class="flex-fill">
                  <div class="small text-secondary">Visit OP</div>
                  <div class="fw-bold" style="font-size:1.85rem; color: #1e293b;">
                    {{ $fmtInt($visit_total_op ?? 0) }}
                  </div>
                </div>
                <div class="vr mx-2 d-none d-sm-block" style="opacity:0.15;"></div>
                <!-- visit pp -->
                <div class="flex-fill">
                  <div class="small text-secondary">Visit PP</div>
                  <div class="fw-bold text-primary" style="font-size:1.85rem;">
                    {{ $fmtInt($visit_total_pp ?? 0) }}
                  </div>
                </div>
                <div class="vr mx-2 d-none d-sm-block" style="opacity:0.15;"></div>
                <!-- endpoint สปสช -->
                <div class="flex-fill">
                  <div class="small text-secondary">ปิดสิทธิ สปสช.</div>
                  <div class="fw-bold text-success" style="font-size:1.85rem;">
                    {{ $fmtInt($visit_endpoint ?? 0) }}
                  </div>
                </div>
              </div>
            </div>
          </a>
        </div>

        {{-- กราฟแยกสิทธิ วันนี้ --}}
        <div class="col-12 col-xl-8">
          <div class="card card-theme-chart card-hover p-3 h-100">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <h6 class="mb-0 text-success fw-bold"><i class="fa-solid fa-chart-bar me-1"></i> ผู้ป่วยนอกตามสิทธิ วันนี้</h6>
              <span class="text-muted small">รวม 6 กลุ่มสิทธิหลัก</span>
            </div>
            <div style="height: 140px; position: relative;">
              <canvas id="visitRightsChart"></canvas>
            </div>
          </div>          
        </div>

      </div>
    </div>  
  </section>

  <!-- SUMMARY ROW 2 (6 คลินิกบริการเฉพาะทาง) -->
  <section id="summary-clinics" class="py-2">
    <div class="container-fluid">
      <div class="row g-3">     

        {{-- ทันตกรรม --}}
        <div class="col-12 col-sm-6 col-xl-2">
          <a href="#" data-bs-toggle="modal" data-bs-target="#DentDetailModal" class="text-decoration-none text-dark">
            <div class="card card-theme-dent card-hover p-3 h-100">
              <div class="d-flex align-items-center justify-content-between mb-2">
                <h6 class="mb-0 fw-bold" style="color:#ab47bc; font-size: 0.9rem;">ทันตกรรม วันนี้</h6>
                <div class="rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; background-color: rgba(171, 71, 188, 0.1);">
                  <i class="fa-solid fa-tooth fs-5" style="color:#ab47bc;"></i>
                </div>
              </div>
              <div class="text-center mt-2">                
                <div class="fw-bold" style="font-size:1.7rem; color:#D946EF;">
                  {{ $fmtInt($visit_dent ?? 0) }}
                </div>
                <div class="small text-secondary">Visit</div>
              </div>
            </div>
          </a>
        </div>

        {{-- กายภาพบำบัด --}}
        <div class="col-12 col-sm-6 col-xl-2">
          <a href="#" data-bs-toggle="modal" data-bs-target="#PhyDetailModal" class="text-decoration-none text-dark">
            <div class="card card-theme-phy card-hover p-3 h-100">
              <div class="d-flex align-items-center justify-content-between mb-2">
                <h6 class="mb-0 fw-bold" style="color:#ff7043; font-size: 0.9rem;">กายภาพบำบัด วันนี้</h6>
                <div class="rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; background-color: rgba(255, 112, 67, 0.1);">
                  <i class="fa-solid fa-person-walking fs-5" style="color:#ff7043;"></i>
                </div>
              </div>
              <div class="text-center mt-2">                
                <div class="fw-bold" style="font-size:1.7rem; color:#ff8a65;">
                  {{ $fmtInt($visit_physic ?? 0) }}
                </div>
                <div class="small text-secondary">Visit</div>
              </div>
            </div>
          </a>
        </div>

        {{-- ฝากครรภ์ ANC --}}
        <div class="col-12 col-sm-6 col-xl-2">
          <a href="#" data-bs-toggle="modal" data-bs-target="#AncDetailModal" class="text-decoration-none text-dark">
            <div class="card card-theme-anc card-hover p-3 h-100">
              <div class="d-flex align-items-center justify-content-between mb-2">
                <h6 class="mb-0 fw-bold" style="color:#ec407a; font-size: 0.9rem;">ฝากครรภ์ วันนี้</h6>
                <div class="rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; background-color: rgba(236, 64, 122, 0.1);">
                  <i class="fa-solid fa-person-pregnant fs-5" style="color:#ec407a;"></i>
                </div>
              </div>
              <div class="text-center mt-2">                
                <div class="fw-bold" style="font-size:1.7rem; color:#f06292;">
                  {{ $fmtInt($visit_anc ?? 0) }}
                </div>
                <div class="small text-secondary">Visit</div>
              </div>
            </div>
          </a>
        </div>

        {{-- การแพทย์แผนไทย --}}
        <div class="col-12 col-sm-6 col-xl-2">
          <a href="#" data-bs-toggle="modal" data-bs-target="#HmDetailModal" class="text-decoration-none text-dark">
            <div class="card card-theme-hm card-hover p-3 h-100">
              <div class="d-flex align-items-center justify-content-between mb-2">
                <h6 class="mb-0 fw-bold" style="color:#26a69a; font-size: 0.9rem;">แพทย์แผนไทย วันนี้</h6>
                <div class="rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; background-color: rgba(38, 166, 154, 0.1);">
                  <i class="fa-solid fa-leaf fs-5" style="color:#26a69a;"></i>
                </div>
              </div>
              <div class="text-center mt-2">                
                <div class="fw-bold" style="font-size:1.7rem; color:#4db6ac;">
                  {{ $fmtInt($visit_healthmed ?? 0) }}
                </div>
                <div class="small text-secondary">Visit</div>
              </div>
            </div>
          </a>
        </div>

        {{-- การแพทย์ทางไกล --}}
        <div class="col-12 col-sm-6 col-xl-2">
          <a href="#" data-bs-toggle="modal" data-bs-target="#TeleDetailModal" class="text-decoration-none text-dark">
            <div class="card card-theme-tele card-hover p-3 h-100">
              <div class="d-flex align-items-center justify-content-between mb-2">
                <h6 class="mb-0 fw-bold" style="color:#26c6da; font-size: 0.9rem;">การแพทย์ทางไกล</h6>
                <div class="rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; background-color: rgba(38, 198, 218, 0.1);">
                  <i class="fa-solid fa-video fs-5" style="color:#26c6da;"></i>
                </div>
              </div>
              <div class="text-center mt-2">                
                <div class="fw-bold" style="font-size:1.7rem; color:#00bcd4;">
                  {{ $fmtInt($visit_telehealth ?? 0) }}
                </div>
                <div class="small text-secondary">Visit</div>
              </div>
            </div>
          </a>
        </div>

        {{-- นัดหมายออนไลน์ วันนี้ --}}
        <div class="col-12 col-sm-6 col-xl-2">
          <a href="#" data-bs-toggle="modal" data-bs-target="#OappDetailModal" class="text-decoration-none text-dark">
            <div class="card card-theme-oapp card-hover p-3 h-100">
              <div class="d-flex align-items-center justify-content-between mb-2">
                <h6 class="mb-0 fw-bold" style="color:#66bb6a; font-size: 0.9rem;">นัดหมายออนไลน์</h6>
                <div class="rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; background-color: rgba(102, 187, 106, 0.1);">
                  <i class="fa-solid fa-calendar-days fs-5" style="color:#66bb6a;"></i>
                </div>
              </div>
              <div class="text-center mt-2">
                <div class="d-flex justify-content-center align-items-center gap-2">
                  <div>
                    <div class="fw-bold" style="font-size:1.4rem; color:#42bd41;">
                      {{ $fmtInt($visit_moph_oapp_booking ?? 0) }}
                    </div>
                    <div class="text-secondary" style="font-size: 0.7rem;">จองคิว</div>
                  </div>
                  <div class="vr mx-1" style="opacity:0.2;"></div>
                  <div>
                    <div class="fw-bold" style="font-size:1.4rem; color:#2e7d32;">
                      {{ $fmtInt($visit_moph_oapp ?? 0) }}
                    </div>
                    <div class="text-secondary" style="font-size: 0.7rem;">รับบริการ</div>
                  </div>
                </div>
              </div>
            </div>
          </a>
        </div>

      </div>
    </div>  
  </section>

  {{-- MODALS FOR SUMMARY CARDS --}}
  @include('partials.dashboard_opd_modals')

  <hr class="my-4">

  {{-- เลือกปีงบประมาณ --}}
  <section id="budget-filter" class="pb-2">
      <div class="container-fluid">
        <form method="POST" action="{{ url('web/opd') }}" enctype="multipart/form-data">
        @csrf
          <div class="row g-4 align-items-center">
            <div class="col-lg-8">          
              <h5 class="fw-bold mb-0 text-dark"><i class="fa-solid fa-hospital text-primary me-2"></i>ข้อมูลจำแนกรายโรงพยาบาล</h5>          
            </div>
            <div class="col-lg-4 d-flex justify-content-lg-end">
              <div class="d-flex align-items-center gap-2">
                <select class="form-select rounded-pill px-3 shadow-sm border-0" name="budget_year" style="min-width: 160px; background-color: #ffffff;">
                  @foreach ($budget_year_select as $row)
                    <option value="{{ $row->LEAVE_YEAR_ID }}"
                      {{ (int)$budget_year === (int)$row->LEAVE_YEAR_ID ? 'selected' : '' }}>
                      {{ $row->LEAVE_YEAR_NAME }}
                    </option>
                  @endforeach
                </select>
                <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm"><i class="fa-solid fa-magnifying-glass me-1"></i> {{ __('ค้นหา') }}</button>
              </div>
            </div>
          </div>
        </form>
      </div>
  </section>

  {{-- ข้อมูลบริการรายโรงพยาบาล --}}
  <section id="hospital" class="pb-4">
    <div class="container-fluid">
    
      <!-- NAV PILLS -->
      <ul class="nav nav-pills overflow-auto flex-nowrap pb-1" id="hospPills" role="tablist">
        @foreach($hospitalData as $hospcode => $data)
        @php
          $shortName = preg_replace('/^(โรงพยาบาลสมเด็จพระยุพราช|โรงพยาบาล)/u', 'รพ.', $data['hospname']);
        @endphp
        <li class="nav-item me-2" role="presentation">
          <button class="nav-link {{ $loop->first ? 'active' : '' }}" id="tab-{{ $hospcode }}" data-bs-toggle="pill" data-bs-target="#pane-{{ $hospcode }}" type="button" role="tab" aria-controls="pane-{{ $hospcode }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}">
            <i class="fa-solid fa-hospital me-1"></i> {{ $shortName }}
          </button>
        </li>
        @endforeach
      </ul>

      <!-- TAB PANES -->
      <div class="tab-content mt-3" id="hospPillsContent">

        @foreach($hospitalData as $hospcode => $data)
        @php
          $opd_records = $data['total'];
        @endphp
        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="pane-{{ $hospcode }}" role="tabpanel" aria-labelledby="tab-{{ $hospcode }}" tabindex="0">
          <div class="glass p-3" style="background: rgba(255,255,255,0.85) !important;">
            
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h6 class="fw-bold mb-0 text-dark"><i class="fa-solid fa-chart-column text-primary me-2"></i>[{{ $hospcode }}] ข้อมูลบริการผู้ป่วยนอก OPD {{ $data['hospname'] }} ปีงบประมาณ {{$budget_year}}</h6>
              <div class="d-flex align-items-center gap-2">
                <span class="text-secondary small">Update {{ $data['update_at'] ?? '-' }}</span>
                <button class="btn btn-sm btn-success rounded-pill px-3 shadow-sm" id="btn-{{ $hospcode }}-opd">
                  <i class="fa-solid fa-file-excel me-1"></i> ส่งออก Excel
                </button>
              </div>
            </div>

            <!-- 3 ApexCharts Minimal Style Cards -->
            <div class="row g-3 mb-4">
              {{-- Chart 1: Visits (Blue) --}}
              <div class="col-12 col-lg-4">
                <div class="card card-chart-blue h-100 rounded-4 border-0">
                  <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0"><i class="fa-solid fa-users me-1"></i> ปริมาณผู้รับบริการ OPD</h6>
                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill">รายเดือน</span>
                  </div>
                  <div class="card-body p-2">
                    <div id="chart_{{ $hospcode }}_visits" style="min-height: 220px;"></div>
                  </div>
                </div>
              </div>

              {{-- Chart 2: Income (Green) --}}
              <div class="col-12 col-lg-4">
                <div class="card card-chart-green h-100 rounded-4 border-0">
                  <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0"><i class="fa-solid fa-hand-holding-dollar me-1"></i> ค่ารักษาพยาบาล (บาท)</h6>
                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill">รายได้</span>
                  </div>
                  <div class="card-body p-2">
                    <div id="chart_{{ $hospcode }}_income" style="min-height: 220px;"></div>
                  </div>
                </div>
              </div>

              {{-- Chart 3: Specialty Clinics (Purple) --}}
              <div class="col-12 col-lg-4">
                <div class="card card-chart-purple h-100 rounded-4 border-0">
                  <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0"><i class="fa-solid fa-stethoscope me-1"></i> คลินิกบริการเฉพาะทาง</h6>
                    <span class="badge rounded-pill" style="background-color: rgba(139, 92, 246, 0.1); color: #8b5cf6;">Visit</span>
                  </div>
                  <div class="card-body p-2">
                    <div id="chart_{{ $hospcode }}_specialty" style="min-height: 220px;"></div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Table -->
            <div class="table-responsive">
              <table id="table{{ $hospcode }}_opd" class="table custom-table my-3" width="100%">
                <thead>
                  <tr>
                    <th rowspan="2" class="th-grey" width="6%">เดือน</th>
                    <th colspan="3" class="th-blue">ปริมาณบริการ</th>
                    <th colspan="3" class="th-green">ค่ารักษาพยาบาล (บาท)</th>
                    <th colspan="4" class="th-purple">คลินิกเฉพาะทาง</th>
                    <th colspan="5" class="th-orange">ผู้ป่วยนอกแยกตามสิทธิ (Visit)</th>
                  </tr>
                  <tr>
                    {{-- ปริมาณบริการ --}}
                    <th class="th-blue">Visit รวม</th>
                    <th class="th-blue">Visit OP</th>
                    <th class="th-blue">Visit PP</th>
                    {{-- ค่ารักษา --}}
                    <th class="th-green">ค่ารักษารวม</th>
                    <th class="th-green">ค่ายา</th>
                    <th class="th-green">ค่า Lab</th>
                    {{-- คลินิกเฉพาะทาง --}}
                    <th class="th-purple">ทันตกรรม</th>
                    <th class="th-purple">กายภาพ</th>
                    <th class="th-purple">แผนไทย</th>
                    <th class="th-purple">ฝากครรภ์</th>
                    {{-- สิทธิ --}}
                    <th class="th-orange">บัตรทองในคัพ</th>
                    <th class="th-orange">บัตรทองนอก จว.</th>
                    <th class="th-orange">ข้าราชการ</th>
                    <th class="th-orange">อปท.</th>
                    <th class="th-orange">ประกันสังคม</th>
                  </tr>
                </thead>
                <tbody>
                  @php
                    $t_visit = 0; $t_op = 0; $t_pp = 0;
                    $t_inc = 0; $t_drug = 0; $t_lab = 0;
                    $t_dent = 0; $t_phy = 0; $t_hm = 0; $t_anc = 0;
                    $t_ucs_in = 0; $t_ucs_out = 0; $t_ofc = 0; $t_lgo = 0; $t_sss = 0;
                  @endphp
                  @foreach($opd_records as $row)
                    @php
                      $t_visit += $row->visit_total ?? 0;
                      $t_op += $row->visit_total_op ?? 0;
                      $t_pp += $row->visit_total_pp ?? 0;
                      $t_inc += $row->inc_total ?? 0;
                      $t_drug += $row->inc_drug_total ?? 0;
                      $t_lab += $row->inc_lab_total ?? 0;
                      $t_dent += $row->visit_dent ?? 0;
                      $t_phy += $row->visit_physic ?? 0;
                      $t_hm += $row->visit_healthmed ?? 0;
                      $t_anc += $row->visit_anc ?? 0;
                      $t_ucs_in += $row->visit_ucs_incup ?? 0;
                      $t_ucs_out += $row->visit_ucs_outprov ?? 0;
                      $t_ofc += $row->visit_ofc ?? 0;
                      $t_lgo += $row->visit_lgo ?? 0;
                      $t_sss += $row->visit_sss ?? 0;
                    @endphp
                    <tr>
                      <td class="text-center fw-bold">{{ $row->month }}</td>
                      <td class="text-end fw-bold text-primary">{{ number_format($row->visit_total) }}</td>
                      <td class="text-end">{{ number_format($row->visit_total_op) }}</td>
                      <td class="text-end">{{ number_format($row->visit_total_pp) }}</td>
                      <td class="text-end fw-bold text-success">{{ number_format($row->inc_total, 2) }}</td>
                      <td class="text-end">{{ number_format($row->inc_drug_total, 2) }}</td>
                      <td class="text-end">{{ number_format($row->inc_lab_total, 2) }}</td>
                      <td class="text-end">{{ number_format($row->visit_dent) }}</td>
                      <td class="text-end">{{ number_format($row->visit_physic) }}</td>
                      <td class="text-end">{{ number_format($row->visit_healthmed) }}</td>
                      <td class="text-end">{{ number_format($row->visit_anc) }}</td>
                      <td class="text-end">{{ number_format($row->visit_ucs_incup) }}</td>
                      <td class="text-end">{{ number_format($row->visit_ucs_outprov) }}</td>
                      <td class="text-end">{{ number_format($row->visit_ofc) }}</td>
                      <td class="text-end">{{ number_format($row->visit_lgo) }}</td>
                      <td class="text-end">{{ number_format($row->visit_sss) }}</td>
                    </tr>
                  @endforeach
                  {{-- TOTAL ROW --}}
                  <tr class="tr-total">
                    <td class="text-center text-primary">รวม</td>
                    <td class="text-end text-primary">{{ number_format($t_visit) }}</td>
                    <td class="text-end">{{ number_format($t_op) }}</td>
                    <td class="text-end">{{ number_format($t_pp) }}</td>
                    <td class="text-end text-success">{{ number_format($t_inc, 2) }}</td>
                    <td class="text-end">{{ number_format($t_drug, 2) }}</td>
                    <td class="text-end">{{ number_format($t_lab, 2) }}</td>
                    <td class="text-end">{{ number_format($t_dent) }}</td>
                    <td class="text-end">{{ number_format($t_phy) }}</td>
                    <td class="text-end">{{ number_format($t_hm) }}</td>
                    <td class="text-end">{{ number_format($t_anc) }}</td>
                    <td class="text-end">{{ number_format($t_ucs_in) }}</td>
                    <td class="text-end">{{ number_format($t_ucs_out) }}</td>
                    <td class="text-end">{{ number_format($t_ofc) }}</td>
                    <td class="text-end">{{ number_format($t_lgo) }}</td>
                    <td class="text-end">{{ number_format($t_sss) }}</td>
                  </tr>
                </tbody>
              </table>
            </div>

          </div>

          <!-- ข้อมูลค่ารักษาพยาบาลผู้ป่วยนอก OPD แยกกลุ่มสิทธิ -->
          <div class="glass p-3 mt-4" style="background: rgba(255,255,255,0.85) !important;">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <h6 class="fw-bold mb-0"><i class="fa-solid fa-file-invoice-dollar text-success me-2"></i>[{{ $hospcode }}] ข้อมูลค่ารักษาพยาบาลผู้ป่วยนอก OPD แยกกลุ่มสิทธิ {{ $data['hospname'] }} ปีงบประมาณ {{$budget_year}}</h6>
              <div class="d-flex align-items-center gap-2">
                <span class="text-secondary small">Update {{ $data['update_at'] ?? '-' }}</span>
              </div>
            </div>

            <!-- 2x2 Donut Charts Grid (ซ้าย 5 ขวา 6 กลางวงกลม) -->
            <!-- Row 1: Visit & Total Income -->
            <div class="row g-3 mb-3 mt-2">
              <!-- Donut Chart 1: Visit by Rights -->
              <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white bg-opacity-75" style="border-top: 4px solid #2563eb !important; height: 100%;">
                  <h6 class="fw-bold text-center mb-3" style="color: #6f42c1;"><i class="fa-solid fa-chart-pie me-1"></i>สัดส่วน Visit แยกสิทธิ</h6>
                  <div class="row align-items-center">
                    <!-- Left Legend (5 items) -->
                    <div class="col-md-3 d-flex flex-column gap-2 small py-2">
                      <span class="d-flex align-items-center justify-content-between gap-1 fw-medium text-secondary w-100"><span class="d-flex align-items-center gap-1"><span class="rounded-circle" style="display:inline-block; width:10px; height:10px; background-color:#2563eb; flex-shrink:0;"></span> UCS ใน CUP</span><span class="fw-bold text-dark legend-val"></span></span>
                      <span class="d-flex align-items-center justify-content-between gap-1 fw-medium text-secondary w-100"><span class="d-flex align-items-center gap-1"><span class="rounded-circle" style="display:inline-block; width:10px; height:10px; background-color:#3b82f6; flex-shrink:0;"></span> UCS ในจังหวัด</span><span class="fw-bold text-dark legend-val"></span></span>
                      <span class="d-flex align-items-center justify-content-between gap-1 fw-medium text-secondary w-100"><span class="d-flex align-items-center gap-1"><span class="rounded-circle" style="display:inline-block; width:10px; height:10px; background-color:#60a5fa; flex-shrink:0;"></span> UCS นอกจังหวัด</span><span class="fw-bold text-dark legend-val"></span></span>
                      <span class="d-flex align-items-center justify-content-between gap-1 fw-medium text-secondary w-100"><span class="d-flex align-items-center gap-1"><span class="rounded-circle" style="display:inline-block; width:10px; height:10px; background-color:#10b981; flex-shrink:0;"></span> OFC ข้าราชการ</span><span class="fw-bold text-dark legend-val"></span></span>
                      <span class="d-flex align-items-center justify-content-between gap-1 fw-medium text-secondary w-100"><span class="d-flex align-items-center gap-1"><span class="rounded-circle" style="display:inline-block; width:10px; height:10px; background-color:#a855f7; flex-shrink:0;"></span> BKK กทม.</span><span class="fw-bold text-dark legend-val"></span></span>
                    </div>
                    <!-- Center Donut -->
                    <div class="col-md-6 text-center">
                      <div id="chart_{{ $hospcode }}_inc_visit" style="min-height: 220px;"></div>
                    </div>
                    <!-- Right Legend (6 items) -->
                    <div class="col-md-3 d-flex flex-column gap-2 small py-2">
                      <span class="d-flex align-items-center justify-content-between gap-1 fw-medium text-secondary w-100"><span class="d-flex align-items-center gap-1"><span class="rounded-circle" style="display:inline-block; width:10px; height:10px; background-color:#ec4899; flex-shrink:0;"></span> BMT ขสมก.</span><span class="fw-bold text-dark legend-val"></span></span>
                      <span class="d-flex align-items-center justify-content-between gap-1 fw-medium text-secondary w-100"><span class="d-flex align-items-center gap-1"><span class="rounded-circle" style="display:inline-block; width:10px; height:10px; background-color:#f59e0b; flex-shrink:0;"></span> SSS ประกันสังคม</span><span class="fw-bold text-dark legend-val"></span></span>
                      <span class="d-flex align-items-center justify-content-between gap-1 fw-medium text-secondary w-100"><span class="d-flex align-items-center gap-1"><span class="rounded-circle" style="display:inline-block; width:10px; height:10px; background-color:#f97316; flex-shrink:0;"></span> LGO อปท.</span><span class="fw-bold text-dark legend-val"></span></span>
                      <span class="d-flex align-items-center justify-content-between gap-1 fw-medium text-secondary w-100"><span class="d-flex align-items-center gap-1"><span class="rounded-circle" style="display:inline-block; width:10px; height:10px; background-color:#06b6d4; flex-shrink:0;"></span> FSS ต่างด้าว</span><span class="fw-bold text-dark legend-val"></span></span>
                      <span class="d-flex align-items-center justify-content-between gap-1 fw-medium text-secondary w-100"><span class="d-flex align-items-center gap-1"><span class="rounded-circle" style="display:inline-block; width:10px; height:10px; background-color:#84cc16; flex-shrink:0;"></span> STP Stateless</span><span class="fw-bold text-dark legend-val"></span></span>
                      <span class="d-flex align-items-center justify-content-between gap-1 fw-medium text-secondary w-100"><span class="d-flex align-items-center gap-1"><span class="rounded-circle" style="display:inline-block; width:10px; height:10px; background-color:#6b7280; flex-shrink:0;"></span> ชำระเงิน/พรบ.</span><span class="fw-bold text-dark legend-val"></span></span>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Donut Chart 2: Income by Rights -->
              <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white bg-opacity-75" style="border-top: 4px solid #10b981 !important; height: 100%;">
                  <h6 class="fw-bold text-center mb-3" style="color: #6f42c1;"><i class="fa-solid fa-chart-pie me-1"></i>สัดส่วนค่ารักษา แยกสิทธิ</h6>
                  <div class="row align-items-center">
                    <!-- Left Legend (5 items) -->
                    <div class="col-md-3 d-flex flex-column gap-2 small py-2">
                      <span class="d-flex align-items-center justify-content-between gap-1 fw-medium text-secondary w-100"><span class="d-flex align-items-center gap-1"><span class="rounded-circle" style="display:inline-block; width:10px; height:10px; background-color:#2563eb; flex-shrink:0;"></span> UCS ใน CUP</span><span class="fw-bold text-dark legend-val"></span></span>
                      <span class="d-flex align-items-center justify-content-between gap-1 fw-medium text-secondary w-100"><span class="d-flex align-items-center gap-1"><span class="rounded-circle" style="display:inline-block; width:10px; height:10px; background-color:#3b82f6; flex-shrink:0;"></span> UCS ในจังหวัด</span><span class="fw-bold text-dark legend-val"></span></span>
                      <span class="d-flex align-items-center justify-content-between gap-1 fw-medium text-secondary w-100"><span class="d-flex align-items-center gap-1"><span class="rounded-circle" style="display:inline-block; width:10px; height:10px; background-color:#60a5fa; flex-shrink:0;"></span> UCS นอกจังหวัด</span><span class="fw-bold text-dark legend-val"></span></span>
                      <span class="d-flex align-items-center justify-content-between gap-1 fw-medium text-secondary w-100"><span class="d-flex align-items-center gap-1"><span class="rounded-circle" style="display:inline-block; width:10px; height:10px; background-color:#10b981; flex-shrink:0;"></span> OFC ข้าราชการ</span><span class="fw-bold text-dark legend-val"></span></span>
                      <span class="d-flex align-items-center justify-content-between gap-1 fw-medium text-secondary w-100"><span class="d-flex align-items-center gap-1"><span class="rounded-circle" style="display:inline-block; width:10px; height:10px; background-color:#a855f7; flex-shrink:0;"></span> BKK กทม.</span><span class="fw-bold text-dark legend-val"></span></span>
                    </div>
                    <!-- Center Donut -->
                    <div class="col-md-6 text-center">
                      <div id="chart_{{ $hospcode }}_inc_total" style="min-height: 220px;"></div>
                    </div>
                    <!-- Right Legend (6 items) -->
                    <div class="col-md-3 d-flex flex-column gap-2 small py-2">
                      <span class="d-flex align-items-center justify-content-between gap-1 fw-medium text-secondary w-100"><span class="d-flex align-items-center gap-1"><span class="rounded-circle" style="display:inline-block; width:10px; height:10px; background-color:#ec4899; flex-shrink:0;"></span> BMT ขสมก.</span><span class="fw-bold text-dark legend-val"></span></span>
                      <span class="d-flex align-items-center justify-content-between gap-1 fw-medium text-secondary w-100"><span class="d-flex align-items-center gap-1"><span class="rounded-circle" style="display:inline-block; width:10px; height:10px; background-color:#f59e0b; flex-shrink:0;"></span> SSS ประกันสังคม</span><span class="fw-bold text-dark legend-val"></span></span>
                      <span class="d-flex align-items-center justify-content-between gap-1 fw-medium text-secondary w-100"><span class="d-flex align-items-center gap-1"><span class="rounded-circle" style="display:inline-block; width:10px; height:10px; background-color:#f97316; flex-shrink:0;"></span> LGO อปท.</span><span class="fw-bold text-dark legend-val"></span></span>
                      <span class="d-flex align-items-center justify-content-between gap-1 fw-medium text-secondary w-100"><span class="d-flex align-items-center gap-1"><span class="rounded-circle" style="display:inline-block; width:10px; height:10px; background-color:#06b6d4; flex-shrink:0;"></span> FSS ต่างด้าว</span><span class="fw-bold text-dark legend-val"></span></span>
                      <span class="d-flex align-items-center justify-content-between gap-1 fw-medium text-secondary w-100"><span class="d-flex align-items-center gap-1"><span class="rounded-circle" style="display:inline-block; width:10px; height:10px; background-color:#84cc16; flex-shrink:0;"></span> STP Stateless</span><span class="fw-bold text-dark legend-val"></span></span>
                      <span class="d-flex align-items-center justify-content-between gap-1 fw-medium text-secondary w-100"><span class="d-flex align-items-center gap-1"><span class="rounded-circle" style="display:inline-block; width:10px; height:10px; background-color:#6b7280; flex-shrink:0;"></span> ชำระเงิน/พรบ.</span><span class="fw-bold text-dark legend-val"></span></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Row 2: Lab & Drug -->
            <div class="row g-3 mb-4">
              <!-- Donut Chart 3: Lab by Rights -->
              <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white bg-opacity-75" style="border-top: 4px solid #f59e0b !important; height: 100%;">
                  <h6 class="fw-bold text-center mb-3" style="color: #6f42c1;"><i class="fa-solid fa-chart-pie me-1"></i>สัดส่วนค่า Lab แยกสิทธิ</h6>
                  <div class="row align-items-center">
                    <!-- Left Legend (5 items) -->
                    <div class="col-md-3 d-flex flex-column gap-2 small py-2">
                      <span class="d-flex align-items-center justify-content-between gap-1 fw-medium text-secondary w-100"><span class="d-flex align-items-center gap-1"><span class="rounded-circle" style="display:inline-block; width:10px; height:10px; background-color:#2563eb; flex-shrink:0;"></span> UCS ใน CUP</span><span class="fw-bold text-dark legend-val"></span></span>
                      <span class="d-flex align-items-center justify-content-between gap-1 fw-medium text-secondary w-100"><span class="d-flex align-items-center gap-1"><span class="rounded-circle" style="display:inline-block; width:10px; height:10px; background-color:#3b82f6; flex-shrink:0;"></span> UCS ในจังหวัด</span><span class="fw-bold text-dark legend-val"></span></span>
                      <span class="d-flex align-items-center justify-content-between gap-1 fw-medium text-secondary w-100"><span class="d-flex align-items-center gap-1"><span class="rounded-circle" style="display:inline-block; width:10px; height:10px; background-color:#60a5fa; flex-shrink:0;"></span> UCS นอกจังหวัด</span><span class="fw-bold text-dark legend-val"></span></span>
                      <span class="d-flex align-items-center justify-content-between gap-1 fw-medium text-secondary w-100"><span class="d-flex align-items-center gap-1"><span class="rounded-circle" style="display:inline-block; width:10px; height:10px; background-color:#10b981; flex-shrink:0;"></span> OFC ข้าราชการ</span><span class="fw-bold text-dark legend-val"></span></span>
                      <span class="d-flex align-items-center justify-content-between gap-1 fw-medium text-secondary w-100"><span class="d-flex align-items-center gap-1"><span class="rounded-circle" style="display:inline-block; width:10px; height:10px; background-color:#a855f7; flex-shrink:0;"></span> BKK กทม.</span><span class="fw-bold text-dark legend-val"></span></span>
                    </div>
                    <!-- Center Donut -->
                    <div class="col-md-6 text-center">
                      <div id="chart_{{ $hospcode }}_inc_lab" style="min-height: 220px;"></div>
                    </div>
                    <!-- Right Legend (6 items) -->
                    <div class="col-md-3 d-flex flex-column gap-2 small py-2">
                      <span class="d-flex align-items-center justify-content-between gap-1 fw-medium text-secondary w-100"><span class="d-flex align-items-center gap-1"><span class="rounded-circle" style="display:inline-block; width:10px; height:10px; background-color:#ec4899; flex-shrink:0;"></span> BMT ขสมก.</span><span class="fw-bold text-dark legend-val"></span></span>
                      <span class="d-flex align-items-center justify-content-between gap-1 fw-medium text-secondary w-100"><span class="d-flex align-items-center gap-1"><span class="rounded-circle" style="display:inline-block; width:10px; height:10px; background-color:#f59e0b; flex-shrink:0;"></span> SSS ประกันสังคม</span><span class="fw-bold text-dark legend-val"></span></span>
                      <span class="d-flex align-items-center justify-content-between gap-1 fw-medium text-secondary w-100"><span class="d-flex align-items-center gap-1"><span class="rounded-circle" style="display:inline-block; width:10px; height:10px; background-color:#f97316; flex-shrink:0;"></span> LGO อปท.</span><span class="fw-bold text-dark legend-val"></span></span>
                      <span class="d-flex align-items-center justify-content-between gap-1 fw-medium text-secondary w-100"><span class="d-flex align-items-center gap-1"><span class="rounded-circle" style="display:inline-block; width:10px; height:10px; background-color:#06b6d4; flex-shrink:0;"></span> FSS ต่างด้าว</span><span class="fw-bold text-dark legend-val"></span></span>
                      <span class="d-flex align-items-center justify-content-between gap-1 fw-medium text-secondary w-100"><span class="d-flex align-items-center gap-1"><span class="rounded-circle" style="display:inline-block; width:10px; height:10px; background-color:#84cc16; flex-shrink:0;"></span> STP Stateless</span><span class="fw-bold text-dark legend-val"></span></span>
                      <span class="d-flex align-items-center justify-content-between gap-1 fw-medium text-secondary w-100"><span class="d-flex align-items-center gap-1"><span class="rounded-circle" style="display:inline-block; width:10px; height:10px; background-color:#6b7280; flex-shrink:0;"></span> ชำระเงิน/พรบ.</span><span class="fw-bold text-dark legend-val"></span></span>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Donut Chart 4: Drug by Rights -->
              <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white bg-opacity-75" style="border-top: 4px solid #8b5cf6 !important; height: 100%;">
                  <h6 class="fw-bold text-center mb-3" style="color: #6f42c1;"><i class="fa-solid fa-chart-pie me-1"></i>สัดส่วนค่ายา แยกสิทธิ</h6>
                  <div class="row align-items-center">
                    <!-- Left Legend (5 items) -->
                    <div class="col-md-3 d-flex flex-column gap-2 small py-2">
                      <span class="d-flex align-items-center justify-content-between gap-1 fw-medium text-secondary w-100"><span class="d-flex align-items-center gap-1"><span class="rounded-circle" style="display:inline-block; width:10px; height:10px; background-color:#2563eb; flex-shrink:0;"></span> UCS ใน CUP</span><span class="fw-bold text-dark legend-val"></span></span>
                      <span class="d-flex align-items-center justify-content-between gap-1 fw-medium text-secondary w-100"><span class="d-flex align-items-center gap-1"><span class="rounded-circle" style="display:inline-block; width:10px; height:10px; background-color:#3b82f6; flex-shrink:0;"></span> UCS ในจังหวัด</span><span class="fw-bold text-dark legend-val"></span></span>
                      <span class="d-flex align-items-center justify-content-between gap-1 fw-medium text-secondary w-100"><span class="d-flex align-items-center gap-1"><span class="rounded-circle" style="display:inline-block; width:10px; height:10px; background-color:#60a5fa; flex-shrink:0;"></span> UCS นอกจังหวัด</span><span class="fw-bold text-dark legend-val"></span></span>
                      <span class="d-flex align-items-center justify-content-between gap-1 fw-medium text-secondary w-100"><span class="d-flex align-items-center gap-1"><span class="rounded-circle" style="display:inline-block; width:10px; height:10px; background-color:#10b981; flex-shrink:0;"></span> OFC ข้าราชการ</span><span class="fw-bold text-dark legend-val"></span></span>
                      <span class="d-flex align-items-center justify-content-between gap-1 fw-medium text-secondary w-100"><span class="d-flex align-items-center gap-1"><span class="rounded-circle" style="display:inline-block; width:10px; height:10px; background-color:#a855f7; flex-shrink:0;"></span> BKK กทม.</span><span class="fw-bold text-dark legend-val"></span></span>
                    </div>
                    <!-- Center Donut -->
                    <div class="col-md-6 text-center">
                      <div id="chart_{{ $hospcode }}_inc_drug" style="min-height: 220px;"></div>
                    </div>
                    <!-- Right Legend (6 items) -->
                    <div class="col-md-3 d-flex flex-column gap-2 small py-2">
                      <span class="d-flex align-items-center justify-content-between gap-1 fw-medium text-secondary w-100"><span class="d-flex align-items-center gap-1"><span class="rounded-circle" style="display:inline-block; width:10px; height:10px; background-color:#ec4899; flex-shrink:0;"></span> BMT ขสมก.</span><span class="fw-bold text-dark legend-val"></span></span>
                      <span class="d-flex align-items-center justify-content-between gap-1 fw-medium text-secondary w-100"><span class="d-flex align-items-center gap-1"><span class="rounded-circle" style="display:inline-block; width:10px; height:10px; background-color:#f59e0b; flex-shrink:0;"></span> SSS ประกันสังคม</span><span class="fw-bold text-dark legend-val"></span></span>
                      <span class="d-flex align-items-center justify-content-between gap-1 fw-medium text-secondary w-100"><span class="d-flex align-items-center gap-1"><span class="rounded-circle" style="display:inline-block; width:10px; height:10px; background-color:#f97316; flex-shrink:0;"></span> LGO อปท.</span><span class="fw-bold text-dark legend-val"></span></span>
                      <span class="d-flex align-items-center justify-content-between gap-1 fw-medium text-secondary w-100"><span class="d-flex align-items-center gap-1"><span class="rounded-circle" style="display:inline-block; width:10px; height:10px; background-color:#06b6d4; flex-shrink:0;"></span> FSS ต่างด้าว</span><span class="fw-bold text-dark legend-val"></span></span>
                      <span class="d-flex align-items-center justify-content-between gap-1 fw-medium text-secondary w-100"><span class="d-flex align-items-center gap-1"><span class="rounded-circle" style="display:inline-block; width:10px; height:10px; background-color:#84cc16; flex-shrink:0;"></span> STP Stateless</span><span class="fw-bold text-dark legend-val"></span></span>
                      <span class="d-flex align-items-center justify-content-between gap-1 fw-medium text-secondary w-100"><span class="d-flex align-items-center gap-1"><span class="rounded-circle" style="display:inline-block; width:10px; height:10px; background-color:#6b7280; flex-shrink:0;"></span> ชำระเงิน/พรบ.</span><span class="fw-bold text-dark legend-val"></span></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Table: Rights Breakdown -->
            <div class="d-flex justify-content-end mb-2">
              <button class="btn btn-sm btn-success rounded-pill px-3 shadow-sm" id="btn-{{ $hospcode }}-inc">
                <i class="fa-solid fa-file-excel me-1"></i> Excel
              </button>
            </div>
            <div class="table-responsive">
              <table id="table{{ $hospcode }}_inc" class="table custom-table my-3" width="100%">
                <thead>
                  <tr>
                    <th class="th-grey" rowspan="2" width="4%">เดือน</th>
                    <th class="th-blue" colspan="4">UCS ใน CUP</th>
                    <th class="th-blue" colspan="4">UCS ในจังหวัด</th>
                    <th class="th-blue" colspan="4">UCS นอกจังหวัด</th>
                    <th class="th-orange" colspan="4">OFC ข้าราชการ</th>
                    <th class="th-purple" colspan="4">BKK กทม.</th>
                    <th class="th-purple" colspan="4">BMT ขสมก.</th>
                    <th class="th-green" colspan="4">SSS ประกันสังคม</th>
                    <th class="th-green" colspan="4">LGO อปท.</th>
                    <th class="th-cyan" colspan="4">FSS ต่างด้าว</th>
                    <th class="th-cyan" colspan="4">STP Stateless</th>
                    <th class="th-grey" colspan="4">ชำระเงิน/พรบ.</th>
                  </tr>
                  <tr>
                    @for ($i = 0; $i < 3; $i++)
                      <th class="th-blue">Visit</th><th class="th-blue">ค่ารักษารวม</th><th class="th-blue">ค่า Lab</th><th class="th-blue">ค่า ยา</th>
                    @endfor
                    <th class="th-orange">Visit</th><th class="th-orange">ค่ารักษารวม</th><th class="th-orange">ค่า Lab</th><th class="th-orange">ค่า ยา</th>
                    @for ($i = 0; $i < 2; $i++)
                      <th class="th-purple">Visit</th><th class="th-purple">ค่ารักษารวม</th><th class="th-purple">ค่า Lab</th><th class="th-purple">ค่า ยา</th>
                    @endfor
                    @for ($i = 0; $i < 2; $i++)
                      <th class="th-green">Visit</th><th class="th-green">ค่ารักษารวม</th><th class="th-green">ค่า Lab</th><th class="th-green">ค่า ยา</th>
                    @endfor
                    @for ($i = 0; $i < 2; $i++)
                      <th class="th-cyan">Visit</th><th class="th-cyan">ค่ารักษารวม</th><th class="th-cyan">ค่า Lab</th><th class="th-cyan">ค่า ยา</th>
                    @endfor
                    <th class="th-grey">Visit</th><th class="th-grey">ค่ารักษารวม</th><th class="th-grey">ค่า Lab</th><th class="th-grey">ค่า ยา</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($opd_records as $row)
                  <tr>
                    <td class="text-center">{{ $row->month }}</td>
                    <td class="text-end">{{ number_format($row->visit_ucs_incup ?? 0) }}</td>
                    <td class="text-end">{{ number_format($row->inc_ucs_incup ?? 0, 2) }}</td>
                    <td class="text-end">{{ number_format($row->inc_lab_ucs_incup ?? 0, 2) }}</td>
                    <td class="text-end">{{ number_format($row->inc_drug_ucs_incup ?? 0, 2) }}</td>
                    <td class="text-end">{{ number_format($row->visit_ucs_inprov ?? 0) }}</td>
                    <td class="text-end">{{ number_format($row->inc_ucs_inprov ?? 0, 2) }}</td>
                    <td class="text-end">{{ number_format($row->inc_lab_ucs_inprov ?? 0, 2) }}</td>
                    <td class="text-end">{{ number_format($row->inc_drug_ucs_inprov ?? 0, 2) }}</td>
                    <td class="text-end">{{ number_format($row->visit_ucs_outprov ?? 0) }}</td>
                    <td class="text-end">{{ number_format($row->inc_ucs_outprov ?? 0, 2) }}</td>
                    <td class="text-end">{{ number_format($row->inc_lab_ucs_outprov ?? 0, 2) }}</td>
                    <td class="text-end">{{ number_format($row->inc_drug_ucs_outprov ?? 0, 2) }}</td>
                    <td class="text-end">{{ number_format($row->visit_ofc ?? 0) }}</td>
                    <td class="text-end">{{ number_format($row->inc_ofc ?? 0, 2) }}</td>
                    <td class="text-end">{{ number_format($row->inc_lab_ofc ?? 0, 2) }}</td>
                    <td class="text-end">{{ number_format($row->inc_drug_ofc ?? 0, 2) }}</td>
                    <td class="text-end">{{ number_format($row->visit_bkk ?? 0) }}</td>
                    <td class="text-end">{{ number_format($row->inc_bkk ?? 0, 2) }}</td>
                    <td class="text-end">{{ number_format($row->inc_lab_bkk ?? 0, 2) }}</td>
                    <td class="text-end">{{ number_format($row->inc_drug_bkk ?? 0, 2) }}</td>
                    <td class="text-end">{{ number_format($row->visit_bmt ?? 0) }}</td>
                    <td class="text-end">{{ number_format($row->inc_bmt ?? 0, 2) }}</td>
                    <td class="text-end">{{ number_format($row->inc_lab_bmt ?? 0, 2) }}</td>
                    <td class="text-end">{{ number_format($row->inc_drug_bmt ?? 0, 2) }}</td>
                    <td class="text-end">{{ number_format($row->visit_sss ?? 0) }}</td>
                    <td class="text-end">{{ number_format($row->inc_sss ?? 0, 2) }}</td>
                    <td class="text-end">{{ number_format($row->inc_lab_sss ?? 0, 2) }}</td>
                    <td class="text-end">{{ number_format($row->inc_drug_sss ?? 0, 2) }}</td>
                    <td class="text-end">{{ number_format($row->visit_lgo ?? 0) }}</td>
                    <td class="text-end">{{ number_format($row->inc_lgo ?? 0, 2) }}</td>
                    <td class="text-end">{{ number_format($row->inc_lab_lgo ?? 0, 2) }}</td>
                    <td class="text-end">{{ number_format($row->inc_drug_lgo ?? 0, 2) }}</td>
                    <td class="text-end">{{ number_format($row->visit_fss ?? 0) }}</td>
                    <td class="text-end">{{ number_format($row->inc_fss ?? 0, 2) }}</td>
                    <td class="text-end">{{ number_format($row->inc_lab_fss ?? 0, 2) }}</td>
                    <td class="text-end">{{ number_format($row->inc_drug_fss ?? 0, 2) }}</td>
                    <td class="text-end">{{ number_format($row->visit_stp ?? 0) }}</td>
                    <td class="text-end">{{ number_format($row->inc_stp ?? 0, 2) }}</td>
                    <td class="text-end">{{ number_format($row->inc_lab_stp ?? 0, 2) }}</td>
                    <td class="text-end">{{ number_format($row->inc_drug_stp ?? 0, 2) }}</td>
                    <td class="text-end">{{ number_format($row->visit_pay ?? 0) }}</td>
                    <td class="text-end">{{ number_format($row->inc_pay ?? 0, 2) }}</td>
                    <td class="text-end">{{ number_format($row->inc_lab_pay ?? 0, 2) }}</td>
                    <td class="text-end">{{ number_format($row->inc_drug_pay ?? 0, 2) }}</td>
                  </tr>
                  @endforeach
                  <tr class="tr-total">
                    <td class="text-center fw-bold">รวม</td>
                    <td class="text-end">{{ number_format($opd_records->sum('visit_ucs_incup')) }}</td>
                    <td class="text-end">{{ number_format($opd_records->sum('inc_ucs_incup'), 2) }}</td>
                    <td class="text-end">{{ number_format($opd_records->sum('inc_lab_ucs_incup'), 2) }}</td>
                    <td class="text-end">{{ number_format($opd_records->sum('inc_drug_ucs_incup'), 2) }}</td>
                    <td class="text-end">{{ number_format($opd_records->sum('visit_ucs_inprov')) }}</td>
                    <td class="text-end">{{ number_format($opd_records->sum('inc_ucs_inprov'), 2) }}</td>
                    <td class="text-end">{{ number_format($opd_records->sum('inc_lab_ucs_inprov'), 2) }}</td>
                    <td class="text-end">{{ number_format($opd_records->sum('inc_drug_ucs_inprov'), 2) }}</td>
                    <td class="text-end">{{ number_format($opd_records->sum('visit_ucs_outprov')) }}</td>
                    <td class="text-end">{{ number_format($opd_records->sum('inc_ucs_outprov'), 2) }}</td>
                    <td class="text-end">{{ number_format($opd_records->sum('inc_lab_ucs_outprov'), 2) }}</td>
                    <td class="text-end">{{ number_format($opd_records->sum('inc_drug_ucs_outprov'), 2) }}</td>
                    <td class="text-end">{{ number_format($opd_records->sum('visit_ofc')) }}</td>
                    <td class="text-end">{{ number_format($opd_records->sum('inc_ofc'), 2) }}</td>
                    <td class="text-end">{{ number_format($opd_records->sum('inc_lab_ofc'), 2) }}</td>
                    <td class="text-end">{{ number_format($opd_records->sum('inc_drug_ofc'), 2) }}</td>
                    <td class="text-end">{{ number_format($opd_records->sum('visit_bkk')) }}</td>
                    <td class="text-end">{{ number_format($opd_records->sum('inc_bkk'), 2) }}</td>
                    <td class="text-end">{{ number_format($opd_records->sum('inc_lab_bkk'), 2) }}</td>
                    <td class="text-end">{{ number_format($opd_records->sum('inc_drug_bkk'), 2) }}</td>
                    <td class="text-end">{{ number_format($opd_records->sum('visit_bmt')) }}</td>
                    <td class="text-end">{{ number_format($opd_records->sum('inc_bmt'), 2) }}</td>
                    <td class="text-end">{{ number_format($opd_records->sum('inc_lab_bmt'), 2) }}</td>
                    <td class="text-end">{{ number_format($opd_records->sum('inc_drug_bmt'), 2) }}</td>
                    <td class="text-end">{{ number_format($opd_records->sum('visit_sss')) }}</td>
                    <td class="text-end">{{ number_format($opd_records->sum('inc_sss'), 2) }}</td>
                    <td class="text-end">{{ number_format($opd_records->sum('inc_lab_sss'), 2) }}</td>
                    <td class="text-end">{{ number_format($opd_records->sum('inc_drug_sss'), 2) }}</td>
                    <td class="text-end">{{ number_format($opd_records->sum('visit_lgo')) }}</td>
                    <td class="text-end">{{ number_format($opd_records->sum('inc_lgo'), 2) }}</td>
                    <td class="text-end">{{ number_format($opd_records->sum('inc_lab_lgo'), 2) }}</td>
                    <td class="text-end">{{ number_format($opd_records->sum('inc_drug_lgo'), 2) }}</td>
                    <td class="text-end">{{ number_format($opd_records->sum('visit_fss')) }}</td>
                    <td class="text-end">{{ number_format($opd_records->sum('inc_fss'), 2) }}</td>
                    <td class="text-end">{{ number_format($opd_records->sum('inc_lab_fss'), 2) }}</td>
                    <td class="text-end">{{ number_format($opd_records->sum('inc_drug_fss'), 2) }}</td>
                    <td class="text-end">{{ number_format($opd_records->sum('visit_stp')) }}</td>
                    <td class="text-end">{{ number_format($opd_records->sum('inc_stp'), 2) }}</td>
                    <td class="text-end">{{ number_format($opd_records->sum('inc_lab_stp'), 2) }}</td>
                    <td class="text-end">{{ number_format($opd_records->sum('inc_drug_stp'), 2) }}</td>
                    <td class="text-end">{{ number_format($opd_records->sum('visit_pay')) }}</td>
                    <td class="text-end">{{ number_format($opd_records->sum('inc_pay'), 2) }}</td>
                    <td class="text-end">{{ number_format($opd_records->sum('inc_lab_pay'), 2) }}</td>
                    <td class="text-end">{{ number_format($opd_records->sum('inc_drug_pay'), 2) }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        @endforeach

      </div>
    </div>
  </section>

@endsection

@push('scripts')
  <script src="{{ asset('assets/vendor/chart.js/chart.umd.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
  
  {{-- DataTables + Buttons --}}
  <script src="{{ asset('assets/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/datatables/js/dataTables.bootstrap5.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/datatables-buttons/js/buttons.bootstrap5.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/jszip/jszip.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/datatables-buttons/js/buttons.html5.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/datatables-buttons/js/buttons.print.min.js') }}"></script>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      // 1. Visit Rights Chart (Bar Chart)
      const ctxRights = document.querySelector('#visitRightsChart');
      if (ctxRights) {
        new Chart(ctxRights, {
          type: 'bar',
          data: {
            labels: ['บัตรทองในคัพ','บัตรทองนอก จว.', 'กรมบัญชีกลาง', 'อปท.', 'ประกันสังคม', 'ชำระเงิน/อื่นๆ'],
            datasets: [{
              label: 'ผู้ป่วยนอก วันนี้',
              data: [
                {{ $visit_ucs_incup ?? 0 }},
                {{ $visit_ucs_outprov ?? 0 }},
                {{ $visit_ofc ?? 0 }},
                {{ $visit_lgo ?? 0 }},
                {{ $visit_sss ?? 0 }},
                {{ $visit_pay ?? 0 }},
              ],
              backgroundColor: [
                'rgba(37, 99, 235, 0.75)',
                'rgba(14, 165, 233, 0.75)',
                'rgba(245, 158, 11, 0.75)',
                'rgba(16, 185, 129, 0.75)',
                'rgba(139, 92, 246, 0.75)',
                'rgba(244, 63, 94, 0.75)'
              ],
              borderRadius: 6,
              borderWidth: 0
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: { display: false },
              tooltip: {
                callbacks: {
                  label: function(context) {
                    return context.formattedValue.toLocaleString() + ' ราย';
                  }
                }
              }
            },
            scales: {
              y: { 
                beginAtZero: true,
                grid: { color: 'rgba(0,0,0,0.05)' }
              },
              x: {
                grid: { display: false }
              }
            }
          }
        });
      }

      // 2. Data from Controller
      const opdData = @json($hospitalData);

      // Common ApexChart Options Generator
      const createApexArea = (elementId, seriesData, categories, colors, yUnit) => {
        const el = document.querySelector(elementId);
        if (!el) return null;
        const options = {
          series: seriesData,
          chart: {
            type: 'area',
            height: 220,
            sparkline: { enabled: false },
            toolbar: { show: false },
            fontFamily: 'inherit',
            animations: { enabled: true, easing: 'easeinout', speed: 500 }
          },
          colors: colors,
          fill: {
            type: 'gradient',
            gradient: {
              shadeIntensity: 1,
              opacityFrom: 0.45,
              opacityTo: 0.05,
              stops: [0, 95, 100]
            }
          },
          stroke: { curve: 'smooth', width: 2.5 },
          xaxis: {
            categories: categories,
            labels: { style: { fontSize: '11px', colors: '#64748b' } },
            axisBorder: { show: false },
            axisTicks: { show: false }
          },
          yaxis: {
            labels: {
              formatter: val => val >= 1000000 ? (val/1000000).toFixed(1) + 'M' : (val >= 1000 ? (val/1000).toFixed(0) + 'k' : Math.round(val)),
              style: { fontSize: '11px', colors: '#64748b' }
            }
          },
          dataLabels: { enabled: false },
          legend: {
            position: 'top',
            horizontalAlign: 'right',
            fontSize: '11px',
            offsetY: -5
          },
          tooltip: {
            y: {
              formatter: val => val ? Math.round(val).toLocaleString('th-TH') + ' ' + (yUnit || '') : '0'
            }
          },
          grid: {
            borderColor: 'rgba(0,0,0,0.05)',
            strokeDashArray: 4
          }
        };
        const chart = new ApexCharts(el, options);
        chart.render();
        return chart;
      };

      // Donut Chart Helpers & Configs
      const rightsLabels = [
        'UCS ใน CUP', 'UCS ในจังหวัด', 'UCS นอกจังหวัด', 'OFC ข้าราชการ', 
        'BKK กทม.', 'BMT ขสมก.', 'SSS ประกันสังคม', 'LGO อปท.', 
        'FSS ต่างด้าว', 'STP Stateless', 'ชำระเงิน/พรบ.'
      ];
      const rightsColors = ['#2563eb', '#3b82f6', '#60a5fa', '#10b981', '#a855f7', '#ec4899', '#f59e0b', '#f97316', '#06b6d4', '#84cc16', '#6b7280'];

      const updateLegend = (chartSelector, series, suffix) => {
        const chartEl = document.querySelector(chartSelector);
        if (!chartEl) return;
        const cardEl = chartEl.closest('.card');
        if (!cardEl) return;
        const valSpans = cardEl.querySelectorAll('.legend-val');
        series.forEach((val, idx) => {
          if (valSpans[idx]) {
            valSpans[idx].textContent = `${Math.round(val).toLocaleString('th-TH')} ${suffix}`;
          }
        });
      };

      const createApexDonut = (elementId, seriesData, labels, colors, totalLabel, isCurrency) => {
        const el = document.querySelector(elementId);
        if (!el) return null;
        const options = {
          series: seriesData,
          labels: labels,
          chart: {
            type: 'donut',
            height: 220,
            animations: { enabled: true }
          },
          stroke: { show: false },
          legend: { show: false },
          dataLabels: { enabled: false },
          plotOptions: {
            pie: {
              donut: {
                size: '70%',
                labels: {
                  show: true,
                  name: {
                    show: true,
                    fontSize: '12px',
                    fontWeight: 600,
                    color: '#6c757d',
                    offsetY: -5
                  },
                  value: {
                    show: true,
                    fontSize: '14px',
                    fontWeight: 700,
                    color: '#212529',
                    offsetY: 5,
                    formatter: val => isCurrency 
                      ? parseFloat(val).toLocaleString('th-TH', { maximumFractionDigits: 0 }) 
                      : Math.round(val).toLocaleString('th-TH')
                  },
                  total: {
                    show: true,
                    label: totalLabel,
                    fontSize: '10px',
                    fontWeight: 600,
                    color: '#6c757d',
                    formatter: w => {
                      const sum = w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                      return isCurrency 
                        ? parseFloat(sum).toLocaleString('th-TH', { maximumFractionDigits: 0 })
                        : Math.round(sum).toLocaleString('th-TH');
                    }
                  }
                }
              }
            }
          },
          tooltip: {
            y: {
              formatter: val => isCurrency
                ? parseFloat(val).toLocaleString('th-TH', { minimumFractionDigits: 2 }) + ' บาท'
                : Math.round(val).toLocaleString('th-TH') + ' ราย'
            }
          },
          colors: colors
        };
        const chart = new ApexCharts(el, options);
        chart.render();
        return chart;
      };

      // Loop each hospital and render ApexCharts and DataTables
      Object.entries(opdData).forEach(([code, h]) => {
        const rows = h.total || [];
        const months = rows.map(r => r.month);

        // Chart 1: Visits
        createApexArea(
          `#chart_${code}_visits`,
          [
            { name: 'Visit รวม', data: rows.map(r => parseInt(r.visit_total || 0)) },
            { name: 'Visit OP', data: rows.map(r => parseInt(r.visit_total_op || 0)) },
            { name: 'Visit PP', data: rows.map(r => parseInt(r.visit_total_pp || 0)) }
          ],
          months,
          ['#2563eb', '#0284c7', '#06b6d4'],
          'ครั้ง'
        );

        // Chart 2: Income
        createApexArea(
          `#chart_${code}_income`,
          [
            { name: 'ค่ารักษารวม', data: rows.map(r => parseFloat(r.inc_total || 0)) },
            { name: 'ค่ายา', data: rows.map(r => parseFloat(r.inc_drug_total || 0)) },
            { name: 'ค่า Lab', data: rows.map(r => parseFloat(r.inc_lab_total || 0)) }
          ],
          months,
          ['#10b981', '#059669', '#34d399'],
          'บาท'
        );

        // Chart 3: Specialty Clinics
        createApexArea(
          `#chart_${code}_specialty`,
          [
            { name: 'ทันตกรรม', data: rows.map(r => parseInt(r.visit_dent || 0)) },
            { name: 'กายภาพ', data: rows.map(r => parseInt(r.visit_physic || 0)) },
            { name: 'แผนไทย', data: rows.map(r => parseInt(r.visit_healthmed || 0)) },
            { name: 'ฝากครรภ์', data: rows.map(r => parseInt(r.visit_anc || 0)) }
          ],
          months,
          ['#8b5cf6', '#a855f7', '#ec4899', '#f43f5e'],
          'Visit'
        );

        // DataTables init for this hospital
        const tblId = `#table${code}_opd`;
        if ($.fn.DataTable && $(tblId).length) {
          const dt = $(tblId).DataTable({
            paging: false,
            searching: false,
            info: false,
            responsive: true,
            order: [],
            buttons: [
              {
                extend: 'excelHtml5',
                text: 'Excel',
                title: `ข้อมูลบริการผู้ป่วยนอก OPD [${code}] ${h.hospname} ปีงบประมาณ {{ $budget_year }}`,
                className: 'd-none'
              }
            ]
          });
          $(`#btn-${code}-opd`).on('click', () => {
            dt.button('.buttons-excel').trigger();
          });
        }

        // Helpers for Donut Charts
        const sumCol = (colName) => rows.reduce((acc, item) => acc + parseFloat(item[colName] || 0), 0);

        // Donut 1: Visits by Rights Group
        const visitSeries = [
          sumCol('visit_ucs_incup'), sumCol('visit_ucs_inprov'), sumCol('visit_ucs_outprov'),
          sumCol('visit_ofc'), sumCol('visit_bkk'), sumCol('visit_bmt'),
          sumCol('visit_sss'), sumCol('visit_lgo'), sumCol('visit_fss'),
          sumCol('visit_stp'), sumCol('visit_pay')
        ];
        createApexDonut(`#chart_${code}_inc_visit`, visitSeries, rightsLabels, rightsColors, 'ทั้งหมด (Visit)', false);
        updateLegend(`#chart_${code}_inc_visit`, visitSeries, 'ราย');

        // Donut 2: Income by Rights Group
        const incomeSeries = [
          sumCol('inc_ucs_incup'), sumCol('inc_ucs_inprov'), sumCol('inc_ucs_outprov'),
          sumCol('inc_ofc'), sumCol('inc_bkk'), sumCol('inc_bmt'),
          sumCol('inc_sss'), sumCol('inc_lgo'), sumCol('inc_fss'),
          sumCol('inc_stp'), sumCol('inc_pay')
        ];
        createApexDonut(`#chart_${code}_inc_total`, incomeSeries, rightsLabels, rightsColors, 'ทั้งหมด (บาท)', true);
        updateLegend(`#chart_${code}_inc_total`, incomeSeries, 'บาท');

        // Donut 3: Lab Income by Rights Group
        const labSeries = [
          sumCol('inc_lab_ucs_incup'), sumCol('inc_lab_ucs_inprov'), sumCol('inc_lab_ucs_outprov'),
          sumCol('inc_lab_ofc'), sumCol('inc_lab_bkk'), sumCol('inc_lab_bmt'),
          sumCol('inc_lab_sss'), sumCol('inc_lab_lgo'), sumCol('inc_lab_fss'),
          sumCol('inc_lab_stp'), sumCol('inc_lab_pay')
        ];
        createApexDonut(`#chart_${code}_inc_lab`, labSeries, rightsLabels, rightsColors, 'ทั้งหมด (บาท)', true);
        updateLegend(`#chart_${code}_inc_lab`, labSeries, 'บาท');

        // Donut 4: Drug Income by Rights Group
        const drugSeries = [
          sumCol('inc_drug_ucs_incup'), sumCol('inc_drug_ucs_inprov'), sumCol('inc_drug_ucs_outprov'),
          sumCol('inc_drug_ofc'), sumCol('inc_drug_bkk'), sumCol('inc_drug_bmt'),
          sumCol('inc_drug_sss'), sumCol('inc_drug_lgo'), sumCol('inc_drug_fss'),
          sumCol('inc_drug_stp'), sumCol('inc_drug_pay')
        ];
        createApexDonut(`#chart_${code}_inc_drug`, drugSeries, rightsLabels, rightsColors, 'ทั้งหมด (บาท)', true);
        updateLegend(`#chart_${code}_inc_drug`, drugSeries, 'บาท');

        // DataTables init for Rights Breakdown Table (#table${code}_inc)
        const incTblId = `#table${code}_inc`;
        if ($.fn.DataTable && $(incTblId).length) {
          const incDt = $(incTblId).DataTable({
            paging: false,
            searching: false,
            info: false,
            ordering: false,
            buttons: [
              {
                extend: 'excelHtml5',
                text: 'Excel',
                title: `ข้อมูลค่ารักษาพยาบาลผู้ป่วยนอก OPD แยกกลุ่มสิทธิ [${code}] ${h.hospname} ปีงบประมาณ {{ $budget_year }}`,
                className: 'd-none'
              }
            ]
          });
          $(`#btn-${code}-inc`).on('click', () => {
            incDt.button('.buttons-excel').trigger();
          });
        }
      });

      // Resize listener for hidden tabs
      $('button[data-bs-toggle="pill"]').on('shown.bs.tab', function () {
        window.dispatchEvent(new Event('resize'));
      });
    });
  </script>
@endpush
