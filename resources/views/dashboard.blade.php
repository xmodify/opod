@extends('layouts.app')

@section('title', 'Dashboard | YSOPOD')

<style>
  .card-hospital {
  border: none;
  backdrop-filter: blur(10px);
  transition: all 0.3s ease-in-out;
  }
  /* เพิ่มสีม่วงสำหรับข้อความ */
  .text-purple {
    color: #8b5cf6 !important;
  }
  tr.table-ipd td,
  tr.table-ipd th {
    background: linear-gradient(135deg, #f3e5f5, #fbf6fc) !important; 
  }
  tr.table-refer td,
  tr.table-refer th {
    background: linear-gradient(135deg, #ceebfa, #e8f6fc) !important;   
  }
</style>
<style>
  /* === BASE GLASS CARD (ใช้ร่วมกันทุก block) === */
  .glass-card {
    backdrop-filter: blur(14px);
    border: 1px solid rgba(255,255,255,0.35);
    box-shadow: 0 8px 20px rgba(0,0,0,0.18);
    color: #fff;
    min-height: 110px;
    padding: 12px 14px !important;
    border-radius: 16px;
    position: relative;
  }
  /* === ICON มุมขวาบน (ใช้ร่วมทุก block) === */
  .glass-icon {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: rgba(255,255,255,0.20);
    border: 1px solid rgba(255,255,255,0.26);
    backdrop-filter: blur(8px);
    display: flex;
    align-items: center;
    justify-content: center;
    position: absolute;
    top: 10px;
    right: 10px;
  }
  .glass-icon i {
    color: #ffffff;
    font-size: 1.05rem;
  }
  /* หัวข้อ */
  .glass-title {
    font-weight: bold;
    font-size: .9rem;
    margin-bottom: 2px;
  }
  /* ตัวเลข */
  .glass-number {
    font-size: 1.75rem;
    font-weight: bold;
    margin-top: 6px;
    text-align: center;
  }
</style>
<style>
  /* ================================
    1) Operation – Deep Green Glass
  =================================*/
  .glass-op {
    background: linear-gradient(135deg,
                rgba(0,120,50,0.55),
                rgba(0,180,90,0.28));
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255,255,255,0.35);
    box-shadow: 0 6px 18px rgba(0,0,0,0.15);
    color: #ffffff;
  }

  .glass-op .glass-title,
  .glass-op .glass-number {
    color: #ffffff !important;
  }

  /* ================================
    2) Refer Out – Magenta Glass
  =================================*/
  .glass-referout {
    background: linear-gradient(135deg,
                rgba(180,40,160,0.55),
                rgba(255,115,195,0.25));
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255,255,255,0.35);
    box-shadow: 0 6px 18px rgba(0,0,0,0.15);
    color: #fff0ff;
  }
  .glass-referout .glass-title,
  .glass-referout .glass-number {
    color: #fff0ff !important;
  }

  /* ================================
    3) Refer In – Pink Red Glass
  =================================*/
  .glass-referin {
    background: linear-gradient(135deg,
                rgba(220,40,90,0.55),
                rgba(255,130,160,0.28));
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255,255,255,0.35);
    box-shadow: 0 6px 18px rgba(0,0,0,0.15);
    color: #ffe6ea;
  }
  .glass-referin .glass-title,
  .glass-referin .glass-number {
    color: #ffffff !important;
  }


  /* ================================
    4) Refer Back – Warm Yellow Glass
  =================================*/
  .glass-referback {
    background: linear-gradient(135deg,
                rgba(255,180,60,0.55),
                rgba(255,225,120,0.28));
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255,255,255,0.35);
    box-shadow: 0 6px 18px rgba(0,0,0,0.15);
    color: #5e4800;
  }
  .glass-referback .glass-title,
  .glass-referback .glass-number {
    color: #5e4800 !important;
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
          {{-- ขวาสุด: select + ปุ่ม ติดกันและชิดขวา --}}
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
      $fmtInt   = fn($n) => number_format((int)($n ?? 0));
      $fmtMoney = fn($n) => number_format((float)($n ?? 0), 2);
    @endphp
  <!-- ข้อมูลเตียง ---------------------------------------------------------------------------------------- -->
  <section id="bed" class="pb-2">
    <div class="container-fluid">
      <div class="row g-3">

        <!-- กำลังรักษาอยู่ (แดงพาสเทล) --------------------------------------------------------------------------------------------->
        <div class="col-12 col-sm-6 col-xl-3">
          <a href="#" data-bs-toggle="modal" data-bs-target="#AdmiitDetailModal"
            class="text-decoration-none text-dark">

            <div class="p-3 h-100 rounded-4 shadow-sm"
                style="background: linear-gradient(135deg, #ffe6e9, #ffffff); border:1px solid #ffd1d7; border-radius:20px;">

              <!-- ส่วนหัว -->
              <div class="d-flex align-items-center justify-content-between mb-3">
                <h6 class="mb-0 text-danger fw-bold">กำลังรักษาอยู่</h6>

                <div class="p-2 rounded-circle shadow-sm"
                    style="background:white; border:1px solid #ffccd2;">
                  <i class="fa-solid fa-hospital-user text-danger fs-4"></i>
                </div>
              </div>

              <!-- ตัวเลข -->
              <div class="d-flex justify-content-between text-center">

                <div class="flex-fill px-1">
                  <div class="small text-secondary">จำนวนเตียง</div>
                  <div class="fw-bold text-primary" style="font-size:1.9rem;">
                    {{ $fmtInt($total_bed_qty ?? 0) }}
                  </div>
                  <i class="fa-solid fa-bed text-primary"></i>
                </div>

                <div class="vr mx-2 d-none d-sm-block"></div>

                <div class="flex-fill px-1">
                  <div class="small text-secondary">Admit</div>
                  <div class="fw-bold text-danger" style="font-size:1.9rem;">
                    {{ $fmtInt($total_bed_use ?? 0) }}
                  </div>
                  <i class="fa-solid fa-bed-pulse text-danger"></i>
                </div>

                <div class="vr mx-2 d-none d-sm-block"></div>

                <div class="flex-fill px-1">
                  <div class="small text-secondary">เตียงว่าง</div>
                  <div class="fw-bold text-success" style="font-size:1.9rem;">
                    {{ $fmtInt($total_bed_empty ?? 0) }}
                  </div>
                  <i class="fa-solid fa-bed text-success"></i>
                </div>

              </div>
            </div>
          </a>
        </div>
        {{-- Modal แสดงรายละเอียด รพ. (โทนน้ำเงินพาสเทลเข้ม / กรอบเล็ก) --}}
        <div class="modal fade" id="AdmiitDetailModal" tabindex="-1" aria-labelledby="hospitalDetailLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg rounded-3" style="background-color:#f5f8fc;">
              
              <!-- Header -->
              <div class="modal-header text-white rounded-top-3" 
                  style="background: linear-gradient(135deg, #2f6fb6, #4b8edc);">
                <h5 class="modal-title fw-bold" id="hospitalDetailLabel">
                  <i class="fa-solid fa-bed-pulse fs-5"></i> ข้อมูลเตียง
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>

              <!-- Body -->
              <div class="modal-body py-3">

                {{-- ✅ หน้ารวมโรงพยาบาล --}}
                <div id="hospital-list">
                  <table class="table table-hover align-middle shadow-sm rounded-3 overflow-hidden mb-0" 
                        style="background-color: #ffffff; border-radius: 0.75rem;">
                    <thead style="background-color:#d9e8fb;">
                      <tr class="text-center text-primary fw-semibold">
                        <th>รหัส</th>
                        <th>ชื่อโรงพยาบาล</th>
                        <th>จำนวนเตียง</th>
                        <th>Admit</th>
                        <th>เตียงว่าง</th>
                        <th>อัตราใช้เตียง (%)</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($ipd_bed_dep as $h)
                        @php
                          $bed_occupancy = $h->bed_qty > 0 ? ($h->bed_use / $h->bed_qty) * 100 : 0;
                          if ($bed_occupancy < 60) {
                            $rate_class = 'text-primary fw-semibold';
                          } elseif ($bed_occupancy < 80) {
                            $rate_class = 'text-warning fw-semibold';
                          } else {
                            $rate_class = 'text-danger fw-semibold';
                          }
                        @endphp

                        <tr>
                          <td align="right" class="text-secondary">{{ $h->hospcode }}</td>
                          <td>
                           <a href="#" 
                              class="fw-semibold text-dark text-decoration-none hosp-detail-link" 
                              data-hospcode="{{ $h->hospcode }}"
                              data-hospname="{{ $h->hospname }}">
                              {{ $h->hospname }}
                            </a><br>
                            <small class="text-muted">
                              {{ \Carbon\Carbon::parse($h->updated_at)->locale('th')->isoFormat('D MMM YYYY H:mm') }} น.
                            </small>
                          </td>
                          <td align="right" class="text-primary">{{ number_format($h->bed_qty) }}</td>
                          <td align="right" class="text-danger">{{ number_format($h->bed_use) }}</td>
                          <td align="right" class="fw-bold text-success">
                            {{ number_format($h->bed_qty - $h->bed_use) }}
                          </td>
                          <td align="right" class="{{ $rate_class }}">
                            {{ number_format($bed_occupancy, 2) }}%
                          </td>
                        </tr>
                      @endforeach

                      {{-- รวม --}}
                      @php
                        $sum_bed_qty = $ipd_bed_dep->sum('bed_qty');
                        $sum_bed_use = $ipd_bed_dep->sum('bed_use');
                        $total_occupancy = $sum_bed_qty > 0 ? ($sum_bed_use / $sum_bed_qty) * 100 : 0;
                      @endphp
                      <tr style="background-color:#eef4fb;" class="fw-bold text-end">
                        <td colspan="2" class="text-center text-dark">รวมทั้งหมด</td>
                        <td class="text-primary">{{ number_format($sum_bed_qty) }}</td>
                        <td class="text-danger">{{ number_format($sum_bed_use) }}</td>
                        <td class="text-success">{{ number_format($sum_bed_qty - $sum_bed_use) }}</td>
                        <td class="text-dark">{{ number_format($total_occupancy, 2) }}%</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                {{-- ✅ หน้ารายละเอียดเตียง (ซ่อนเริ่มต้น) --}}
                <div id="bed-detail" style="display: none;">
                  <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 id="modal-hospname" class="fw-bold text-success mb-0"></h6>
                    <button id="btn-back" class="btn btn-outline-primary btn-sm rounded-pill">
                      <i class="bi bi-arrow-left"></i> กลับ
                    </button>
                  </div>
                  <table class="table table-sm table-bordered align-middle" id="bedDetailTable">
                    <thead class="table-primary text-center">
                      <tr>
                        <th>รหัสเตียง</th>
                        <th>ชื่อแผนก</th>
                        <th>จำนวนเตียง</th>
                        <th>Admit</th>
                        <th>เตียงว่าง</th>
                        <th>อัตราใช้เตียง (%)</th>
                      </tr>
                    </thead>

                    <tbody class="text-center">
                      <tr><td colspan="6" class="text-muted">เลือกโรงพยาบาลเพื่อดูรายละเอียด...</td></tr>
                    </tbody>

                    <tfoot class="table-light text-end fw-bold">
                      <tr>
                        <td colspan="2" class="text-center">รวม</td>
                        <td id="sum-bed"></td>
                        <td id="sum-use"></td>
                        <td id="sum-empty"></td>
                        <td id="sum-rate" class="text-primary"></td>
                      </tr>
                    </tfoot>
                  </table>
                </div>

              </div>
              <!-- Footer -->
              <div class="modal-footer" style="background-color:#eef4fb;">
                <button type="button" class="btn btn-primary rounded-pill px-4 shadow-sm" 
                        style="background-color:#3e7cc1; border-color:#3e7cc1;" 
                        data-bs-dismiss="modal">
                  ปิด
                </button>
              </div>
            </div>
          </div>
        </div>

        <script>
          document.addEventListener("DOMContentLoaded", () => {

            const hospitalList = document.getElementById('hospital-list');
            const bedDetail = document.getElementById('bed-detail');
            const btnBack = document.getElementById('btn-back');
            const tbody = document.querySelector('#bedDetailTable tbody');
            const sumBed = document.getElementById('sum-bed');
            const sumUse = document.getElementById('sum-use');
            const sumEmpty = document.getElementById('sum-empty');
            const sumRate = document.getElementById('sum-rate');
            const hospNameEl = document.getElementById('modal-hospname');

            console.log("✅ BedDetail JS Loaded");

            // ✅ คลิกชื่อโรงพยาบาลเพื่อดูรายละเอียดเตียง
            document.addEventListener('click', function (e) {
              const link = e.target.closest('.hosp-detail-link');
              if (!link) return;

              e.preventDefault();
              const hospcode = link.dataset.hospcode;
              const hospname = link.dataset.hospname;

              console.log("🏥 Clicked:", hospcode, hospname);
              hospNameEl.innerText = hospname;
              tbody.innerHTML = `<tr><td colspan="6" class="text-muted">กำลังโหลดข้อมูล...</td></tr>`;

              // ✅ ดึงข้อมูลจาก Controller
              fetch(`{{ url('web/bed_dep') }}/${hospcode}`)
                .then(res => {
                  if (!res.ok) throw new Error(`HTTP ${res.status}`);
                  return res.json();
                })
                .then(data => {
                  tbody.innerHTML = '';

                  if (data.beds && data.beds.length > 0) {
                    data.beds.forEach(b => {
                      const empty = b.bed_qty - b.bed_use;

                      // ✅ ตั้งสีตามอัตราครองเตียง
                      let rateColor = 'text-success';
                      if (b.bed_rate >= 80) rateColor = 'text-danger fw-bold';
                      else if (b.bed_rate >= 60) rateColor = 'text-warning fw-bold';

                      tbody.innerHTML += `
                        <tr>
                          <td class="text-center">${b.bed_code}</td>
                          <td class="text-start">${b.bed_name ?? '-'}</td>
                          <td class="text-end">${b.bed_qty}</td>
                          <td class="text-end text-danger">${b.bed_use}</td>
                          <td class="text-end text-success">${empty}</td>
                          <td class="text-end ${rateColor}">${b.bed_rate}%</td>
                        </tr>`;
                    });
                  } else {
                    tbody.innerHTML = `<tr><td colspan="6" class="text-muted">ไม่พบข้อมูลเตียง</td></tr>`;
                  }

                  // ✅ อัปเดตผลรวม
                  sumBed.innerText = (data.summary?.total || 0).toLocaleString();
                  sumUse.innerText = (data.summary?.used || 0).toLocaleString();
                  sumEmpty.innerText = (data.summary?.empty || 0).toLocaleString();
                  sumRate.innerText = `${data.summary?.rate || 0}%`;

                  // ✅ สลับหน้า
                  hospitalList.style.display = 'none';
                  bedDetail.style.display = 'block';
                })
                .catch(err => {
                  console.error("❌ Fetch error:", err);
                  tbody.innerHTML = `<tr><td colspan="6" class="text-danger">โหลดข้อมูลไม่สำเร็จ</td></tr>`;
                });
            });

            // ✅ ปุ่ม "กลับ" เพื่อกลับมาหน้ารวม
            btnBack.addEventListener('click', () => {
              bedDetail.style.display = 'none';
              hospitalList.style.display = 'block';
            });
          });
        </script>
        <!-- Block แยกแต่ละ รพ ----------------------------------------------------------------------------------------------->
        @php
          $bedColorSchemes = [
            ['bg'=>'linear-gradient(135deg,rgba(13,110,253,0.07),rgba(13,110,253,0.01))','border'=>'rgba(13,110,253,0.2)','icon_color'=>'#0d6efd','num_color'=>'#0b5ed7','hover_shadow'=>'0 10px 28px rgba(13,110,253,0.16)'],
            ['bg'=>'linear-gradient(135deg,rgba(24,165,115,0.07),rgba(24,165,115,0.01))','border'=>'rgba(24,165,115,0.2)','icon_color'=>'#18a573','num_color'=>'#158058','hover_shadow'=>'0 10px 28px rgba(24,165,115,0.16)'],
            ['bg'=>'linear-gradient(135deg,rgba(217,70,239,0.07),rgba(217,70,239,0.01))','border'=>'rgba(217,70,239,0.2)','icon_color'=>'#d946ef','num_color'=>'#c026d3','hover_shadow'=>'0 10px 28px rgba(217,70,239,0.16)'],
            ['bg'=>'linear-gradient(135deg,rgba(249,115,22,0.07),rgba(249,115,22,0.01))','border'=>'rgba(249,115,22,0.2)','icon_color'=>'#f97316','num_color'=>'#ea580c','hover_shadow'=>'0 10px 28px rgba(249,115,22,0.16)'],
            ['bg'=>'linear-gradient(135deg,rgba(99,102,241,0.07),rgba(99,102,241,0.01))','border'=>'rgba(99,102,241,0.2)','icon_color'=>'#6366f1','num_color'=>'#4f46e5','hover_shadow'=>'0 10px 28px rgba(99,102,241,0.16)'],
            ['bg'=>'linear-gradient(135deg,rgba(236,72,153,0.07),rgba(236,72,153,0.01))','border'=>'rgba(236,72,153,0.2)','icon_color'=>'#ec4899','num_color'=>'#db2777','hover_shadow'=>'0 10px 28px rgba(236,72,153,0.16)'],
            ['bg'=>'linear-gradient(135deg,rgba(20,184,166,0.07),rgba(20,184,166,0.01))','border'=>'rgba(20,184,166,0.2)','icon_color'=>'#14b8a6','num_color'=>'#0d9488','hover_shadow'=>'0 10px 28px rgba(20,184,166,0.16)'],
            ['bg'=>'linear-gradient(135deg,rgba(245,158,11,0.07),rgba(245,158,11,0.01))','border'=>'rgba(245,158,11,0.2)','icon_color'=>'#f59e0b','num_color'=>'#d97706','hover_shadow'=>'0 10px 28px rgba(245,158,11,0.16)'],
            ['bg'=>'linear-gradient(135deg,rgba(139,92,246,0.07),rgba(139,92,246,0.01))','border'=>'rgba(139,92,246,0.2)','icon_color'=>'#8b5cf6','num_color'=>'#7c3aed','hover_shadow'=>'0 10px 28px rgba(139,92,246,0.16)'],
          ];
        @endphp
        @foreach($bedData as $hospcode => $data)
        @php $bc = $bedColorSchemes[$loop->index % count($bedColorSchemes)]; @endphp
        <style>
          .bed-card-{{ $hospcode }} { transition: all 0.3s ease; }
          .bed-card-{{ $hospcode }}:hover { transform: translateY(-3px); box-shadow: {{ $bc['hover_shadow'] }} !important; border-color: {{ $bc['icon_color'] }} !important; }
        </style>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card bed-card-{{ $hospcode }} p-3 h-100 rounded-4"
                  style="background: {{ $bc['bg'] }}; border: 1px solid {{ $bc['border'] }}; box-shadow: 0 4px 12px rgba(0,0,0,0.04);">

                <!-- หัวข้อ Card -->
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <div style="font-size:0.82rem; font-weight:700; color:{{ $bc['num_color'] }}; line-height:1.4;">
                    {{ $data['hospname'] }}
                    <span style="font-size:0.7rem; font-weight:500; color:{{ $bc['icon_color'] }}; opacity:0.75;">&nbsp;({{ $hospcode }})</span>
                  </div>
                  <div style="width:32px;height:32px;border-radius:10px;background:rgba(255,255,255,0.6);border:1px solid {{ $bc['border'] }};display:flex;align-items:center;justify-content:center;">
                    <i class="fa-solid fa-bed-pulse" style="color:{{ $bc['icon_color'] }};font-size:0.9rem;"></i>
                  </div>
                </div>

                <!-- Header -->
                <div class="row mb-1">
                    <div class="col-4 small text-secondary">แผนก</div>
                    <div class="col-2 small text-secondary text-center">เตียง</div>
                    <div class="col-2 small text-secondary text-center">Admit</div>
                    <div class="col-2 small text-secondary text-center">ว่าง</div>
                    <div class="col-2 small text-secondary text-center">%</div>
                </div>
                <hr class="my-1" style="border-color:{{ $bc['border'] }};">
                <!-- รายการเตียงแต่ละแผนก -->
                @foreach($data['beds'] as $b)
                    @php $empty = $b->bed_qty - $b->bed_use; @endphp
                    <div class="row mb-1 small align-items-center">
                        <div class="col-4 fw-semibold text-secondary">{{ $b->bed_name }}</div>
                        <div class="col-2 text-center fw-bold" style="color:{{ $bc['num_color'] }};">{{ $b->bed_qty }}</div>
                        <div class="col-2 text-center fw-bold text-danger">{{ $b->bed_use }}</div>
                        <div class="col-2 text-center fw-bold text-success">{{ $empty }}</div>
                        <div class="col-2 text-center fw-bold"
                            @if($b->bed_rate >= 80) style="color:#d32f2f;"
                            @elseif($b->bed_rate >= 60) style="color:#f59e0b;"
                            @else style="color:{{ $bc['icon_color'] }};"
                            @endif>
                            {{ $b->bed_rate }}%
                        </div>
                    </div>
                @endforeach
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
        <form method="POST" action="{{ route('web.index') }}" enctype="multipart/form-data">
        @csrf
          <div class="row g-4 align-items-center">
            <div class="col-lg-9">          
              <h6 class="text-success mb-2"><strong></strong></h6>          
            </div>
            {{-- ขวาสุด: select + ปุ่ม ติดกันและชิดขวา --}}
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

  {{-- ข้อมูลบริการ----------------------------------------------------------------------------------------------------------}}
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
          <!-- IPD -->
          <div class="glass p-3">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <h6>[{{ $hospcode }}] ข้อมูลบริการผู้ป่วยใน IPD {{ $data['hospname'] }} ปีงบประมาณ {{$budget_year}}</h6>
              <span class="text-secondary small">Update {{ $data['update_at'] }}</span>              
            </div>
            <div class="table-responsive">
              <table id="table{{ $hospcode }}_ipd" class="table table-bordered table-striped my-3" width ="100%">
                <thead class="table-light">
                  <tr class="table-ipd">
                    <th class="text-center" rowspan="2" width ="4%">เดือน</th>
                    <th class="text-center" rowspan="2">จำนวน AN</th>
                    <th class="text-center" rowspan="2">วันนอนรวม</th> 
                    <th class="text-center" rowspan="2">อัตราครองเตียง (%)</th>
                    <th class="text-center" rowspan="2">Active Base (เตียง)</th>       
                    <th class="text-center" rowspan="2">AdjRW</th>  
                    <th class="text-center" rowspan="2">CMI</th>
                    <th class="text-center" colspan="3">ค่ารักษาพยาบาล</th>                
                  </tr>    
                  <tr class="table-ipd"> 
                    <td class="text-center text-primary">ค่ารักษารวม</td>
                    <td class="text-center text-primary">ค่า Lab</td>
                    <td class="text-center text-primary">ค่า ยา</td>                 
                  </tr>    
                </thead>
                <tbody>
                  @php 
                    $sum_an_total = 0; 
                    $sum_admdate = 0;   
                    $sum_adjrw = 0; 
                    $sum_inc_total = 0;  
                    $sum_inc_lab_total = 0;
                    $sum_inc_drug_total = 0;
                    // หา bed_report จาก hospital_config เท่านั้น
                    $config = DB::table('hospital_config')->where('hospcode', $hospcode)->first();
                    $bed_report = $config->bed_report ?? 0;
                  @endphp  
                  @foreach($data['ipd'] as $row) 
                  <tr>
                    <td align="center"width ="4%">{{ $row->month }}</td>
                    <td align="right">{{ number_format($row->an_total) }}</td>
                    <td align="right">{{ number_format($row->admdate) }}</td>
                    <td align="right">{{ number_format($row->bed_occupancy,2) }}</td>
                    <td align="right">{{ number_format($row->active_bed,2) }}</td>
                    <td align="right">{{ number_format($row->adjrw,5) }}</td>
                    <td align="right">{{ number_format($row->cmi,2) }}</td>
                    <td align="right">{{ number_format($row->inc_total,2) }}</td>
                    <td align="right">{{ number_format($row->inc_lab_total,2) }}</td>
                    <td align="right">{{ number_format($row->inc_drug_total,2) }}</td>
                  </tr>
                  @php 
                    $sum_an_total += $row->an_total;
                    $sum_admdate += $row->admdate;
                    $sum_adjrw += $row->adjrw;
                    $sum_inc_total += $row->inc_total;
                    $sum_inc_lab_total += $row->inc_lab_total;
                    $sum_inc_drug_total += $row->inc_drug_total;
                  @endphp
                  @endforeach 
                  @php                   
                    // ✅ อัตราครองเตียงรวม
                    $sum_bed_occupancy = ($sum_admdate > 0 && $bed_report > 0 && $diff_days > 0) ? round(($sum_admdate * 100) / ($bed_report * $diff_days), 2) : 0;  
                    // ✅ Active Bed = วันนอนรวม ÷ จำนวนวัน
                    $sum_active_bed = ($sum_admdate > 0 && $diff_days > 0) ? round($sum_admdate / $diff_days, 2) : 0;
                    // ✅ CMI รวม
                    $sum_cmi = ($sum_an_total > 0) ? round($sum_adjrw / $sum_an_total, 2) : 0; 
                  @endphp   
                  <tr>
                    <td align="right"><strong>รวม</strong></td>
                    <td align="right"><strong>{{number_format($sum_an_total)}}</strong></td>
                    <td align="right"><strong>{{number_format($sum_admdate)}}</strong></td>
                    <td align="right"><strong>{{number_format($sum_bed_occupancy,2)}}</td>     
                    <td align="right"><strong>{{number_format($sum_active_bed,2)}}</td>   
                    <td align="right"><strong>{{number_format($sum_adjrw,4)}}</strong></td>  
                    <td align="right"><strong>{{number_format($sum_cmi,2)}}</strong></td> 
                    <td align="right"><strong>{{number_format($sum_inc_total,2)}}</strong></td>
                    <td align="right"><strong>{{number_format($sum_inc_lab_total)}}</strong></td>
                    <td align="right"><strong>{{number_format($sum_inc_drug_total,2)}}</strong></td>
                  </tr>   
                </tbody>
              </table>
              <!-- กราฟ -->
              <div class="row mt-4">
                <!-- กราฟอัตราครองเตียง -->
                <div class="col-md-6 mb-4">
                  <div class="card shadow-sm">
                    <div class="card-body">
                      <h6 class="text-center text-primary mb-1">
                        📈 อัตราครองเตียง (%)
                      </h6>
                      <div id="bed_occupancy_{{ $hospcode }}"></div>
                    </div>
                  </div>
                </div>
                <!-- กราฟ CMI -->
                <div class="col-md-6 mb-4">
                  <div class="card shadow-sm">
                    <div class="card-body">
                      <h6 class="text-center text-danger mb-1">
                        📊 CMI
                      </h6>
                      <div id="cmi_chart_{{ $hospcode }}"></div>
                    </div>
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

<!-- แจังเตือน login--------------------------------------------------------------------------------------------------- -->
   @if($errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'ผิดพลาด',
            text: '{{ $errors->first() }}', // แสดง error แรก
            confirmButtonText: 'ตกลง'
        });
    </script>
    @endif

@endsection

<!-- script datatable  ---------------------------------------------------------------------------------------->
@push('scripts')
  <script>
    $(function () {
      @foreach($hospitalData as $hospcode => $data)
        // IPD Table
        $('#table{{ $hospcode }}_ipd').DataTable({
          dom: '<"d-flex justify-content-end mb-2"B>rt',
          buttons: [
            {
              extend: 'excelHtml5',
              text: '<i class="bi bi-file-earmark-excel"></i> ส่งออก Excel',
              className: 'btn btn-success btn-sm',
              title: 'ข้อมูลบริการผู้ป่วยใน IPD {{ $data['hospname'] }} {{ $budget_year ?? "" }}'
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
        $months = $data['ipd']->pluck('month');
        $bed_occupancy = $data['ipd']->pluck('bed_occupancy');
        $cmi = $data['ipd']->pluck('cmi');
      @endphp

      (function() {
        const months = {!! json_encode($months) !!};
        const bedData = {!! json_encode($bed_occupancy) !!};
        const cmiData = {!! json_encode($cmi) !!};

        // 🩵 กราฟอัตราครองเตียง
        new ApexCharts(document.querySelector("#bed_occupancy_{{ $hospcode }}"), {
          series: [{ name: 'อัตราครองเตียง (%)', data: bedData }],
          chart: { height: 250, type: 'area', toolbar: { show: false } },
          colors: ['#4154f1'],
          stroke: { curve: 'smooth', width: 2 },
          xaxis: { categories: months },
          yaxis: { labels: { formatter: val => val.toFixed(1) } },
          dataLabels: { enabled: true }
        }).render();

        // ❤️ กราฟ CMI
        new ApexCharts(document.querySelector("#cmi_chart_{{ $hospcode }}"), {
          series: [{ name: 'CMI', data: cmiData }],
          chart: { height: 250, type: 'line', toolbar: { show: false } },
          colors: ['#ff771d'],
          stroke: { curve: 'smooth', width: 2 },
          xaxis: { categories: months },
          yaxis: { labels: { formatter: val => val.toFixed(2) } },
          dataLabels: { enabled: true }
        }).render();
      })();
    @endforeach
  });
</script>