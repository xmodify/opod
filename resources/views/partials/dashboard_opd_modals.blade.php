{{-- MODALS FOR OPD DASHBOARD --}}

{{-- 1. ผู้ป่วยนอก OPD วันนี้ --}}
<div class="modal fade" id="VisitDetailModal" tabindex="-1" aria-labelledby="hospitalDetailLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content border-0 shadow-lg rounded-3" style="background-color:#f5f8fc;">
      <div class="modal-header text-white rounded-top-3" style="background: linear-gradient(135deg, #2563eb, #3b82f6);">
        <h5 class="modal-title fw-bold" id="hospitalDetailLabel">
          <i class="bi bi-person-lines-fill me-2"></i> ผู้ป่วยนอก (OPD) วันนี้
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body py-3">
        <table class="table table-hover align-middle shadow-sm rounded-3 overflow-hidden mb-0" style="background-color: #ffffff; border-radius: 0.75rem;">
          <thead style="background-color:#d9e8fb;">
            <tr class="text-center text-primary fw-semibold">
              <th>รหัส</th>
              <th>ชื่อโรงพยาบาล</th>
              <th>Visit OP</th>
              <th>Visit PP</th>
              <th>ปิดสิทธิ สปสช.</th>
            </tr>
          </thead>
          <tbody>
            @foreach($hospitalSummary as $h)
              <tr>
                <td align="right" class="text-secondary">{{ $h->hospcode }}</td>
                <td>
                  <span class="fw-semibold text-dark">{{ $h->hospname }}</span><br>
                  <small class="text-muted">
                    {{ $h->last_updated_at ? \Carbon\Carbon::parse($h->last_updated_at)->locale('th')->isoFormat('D MMM YYYY H:mm') . ' น.' : 'ยังไม่มีข้อมูลส่ง' }}
                  </small>
                </td>
                <td align="right" class="text-primary fw-bold">{{ number_format($h->visit_total_op) }}</td>
                <td align="right" class="text-info fw-bold">{{ number_format($h->visit_total_pp) }}</td>
                <td align="right" class="fw-bold text-success">{{ number_format($h->visit_endpoint) }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="modal-footer" style="background-color:#eef4fb;">
        <button type="button" class="btn btn-primary rounded-pill px-4 shadow-sm" data-bs-dismiss="modal">ปิด</button>
      </div>
    </div>
  </div>
</div>

{{-- 2. ทันตกรรม วันนี้ --}}
<div class="modal fade" id="DentDetailModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content border-0 shadow-lg rounded-3" style="background-color:#f5f8fc;">
      <div class="modal-header text-white rounded-top-3" style="background: linear-gradient(135deg, #ab47bc, #ba68c8);">
        <h5 class="modal-title fw-bold">
          <i class="fa-solid fa-tooth me-2"></i> ทันตกรรม วันนี้
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body py-3">
        <table class="table table-hover align-middle shadow-sm rounded-3 overflow-hidden mb-0" style="background-color: #ffffff; border-radius: 0.75rem;">
          <thead style="background-color:#f3e5f5;">
            <tr class="text-center fw-semibold" style="color: #6a1b9a;">
              <th>รหัส</th>
              <th>ชื่อโรงพยาบาล</th>
              <th>Visit</th>
            </tr>
          </thead>
          <tbody>
            @foreach($hospitalSummary as $h)
              <tr>
                <td align="right" class="text-secondary">{{ $h->hospcode }}</td>
                <td>
                  <span class="fw-semibold text-dark">{{ $h->hospname }}</span><br>
                  <small class="text-muted">
                    {{ $h->last_updated_at ? \Carbon\Carbon::parse($h->last_updated_at)->locale('th')->isoFormat('D MMM YYYY H:mm') . ' น.' : 'ยังไม่มีข้อมูลส่ง' }}
                  </small>
                </td>
                <td align="right" class="fw-bold" style="color:#ab47bc;">{{ number_format($h->visit_dent) }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="modal-footer" style="background-color:#eef4fb;">
        <button type="button" class="btn btn-secondary rounded-pill px-4 shadow-sm" data-bs-dismiss="modal">ปิด</button>
      </div>
    </div>
  </div>
</div>

{{-- 3. กายภาพบำบัด วันนี้ --}}
<div class="modal fade" id="PhyDetailModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content border-0 shadow-lg rounded-3" style="background-color:#f5f8fc;">
      <div class="modal-header text-white rounded-top-3" style="background: linear-gradient(135deg, #ff7043, #ff8a65);">
        <h5 class="modal-title fw-bold">
          <i class="fa-solid fa-person-walking me-2"></i> กายภาพบำบัด วันนี้
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body py-3">
        <table class="table table-hover align-middle shadow-sm rounded-3 overflow-hidden mb-0" style="background-color: #ffffff; border-radius: 0.75rem;">
          <thead style="background-color:#fbe9e7;">
            <tr class="text-center fw-semibold" style="color: #bf360c;">
              <th>รหัส</th>
              <th>ชื่อโรงพยาบาล</th>
              <th>Visit</th>
            </tr>
          </thead>
          <tbody>
            @foreach($hospitalSummary as $h)
              <tr>
                <td align="right" class="text-secondary">{{ $h->hospcode }}</td>
                <td>
                  <span class="fw-semibold text-dark">{{ $h->hospname }}</span><br>
                  <small class="text-muted">
                    {{ $h->last_updated_at ? \Carbon\Carbon::parse($h->last_updated_at)->locale('th')->isoFormat('D MMM YYYY H:mm') . ' น.' : 'ยังไม่มีข้อมูลส่ง' }}
                  </small>
                </td>
                <td align="right" class="fw-bold" style="color:#ff7043;">{{ number_format($h->visit_physic) }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="modal-footer" style="background-color:#eef4fb;">
        <button type="button" class="btn btn-secondary rounded-pill px-4 shadow-sm" data-bs-dismiss="modal">ปิด</button>
      </div>
    </div>
  </div>
</div>

{{-- 4. ฝากครรภ์ ANC วันนี้ --}}
<div class="modal fade" id="AncDetailModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content border-0 shadow-lg rounded-3" style="background-color:#f5f8fc;">
      <div class="modal-header text-white rounded-top-3" style="background: linear-gradient(135deg, #ec407a, #f06292);">
        <h5 class="modal-title fw-bold">
          <i class="fa-solid fa-person-pregnant me-2"></i> ฝากครรภ์ (ANC) วันนี้
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body py-3">
        <table class="table table-hover align-middle shadow-sm rounded-3 overflow-hidden mb-0" style="background-color: #ffffff; border-radius: 0.75rem;">
          <thead style="background-color:#fce4ec;">
            <tr class="text-center fw-semibold" style="color: #880e4f;">
              <th>รหัส</th>
              <th>ชื่อโรงพยาบาล</th>
              <th>Visit</th>
            </tr>
          </thead>
          <tbody>
            @foreach($hospitalSummary as $h)
              <tr>
                <td align="right" class="text-secondary">{{ $h->hospcode }}</td>
                <td>
                  <span class="fw-semibold text-dark">{{ $h->hospname }}</span><br>
                  <small class="text-muted">
                    {{ $h->last_updated_at ? \Carbon\Carbon::parse($h->last_updated_at)->locale('th')->isoFormat('D MMM YYYY H:mm') . ' น.' : 'ยังไม่มีข้อมูลส่ง' }}
                  </small>
                </td>
                <td align="right" class="fw-bold" style="color:#ec407a;">{{ number_format($h->visit_anc) }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="modal-footer" style="background-color:#eef4fb;">
        <button type="button" class="btn btn-secondary rounded-pill px-4 shadow-sm" data-bs-dismiss="modal">ปิด</button>
      </div>
    </div>
  </div>
</div>

{{-- 5. แพทย์แผนไทย วันนี้ --}}
<div class="modal fade" id="HmDetailModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content border-0 shadow-lg rounded-3" style="background-color:#f5f8fc;">
      <div class="modal-header text-white rounded-top-3" style="background: linear-gradient(135deg, #26a69a, #4db6ac);">
        <h5 class="modal-title fw-bold">
          <i class="fa-solid fa-leaf me-2"></i> การแพทย์แผนไทย วันนี้
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body py-3">
        <table class="table table-hover align-middle shadow-sm rounded-3 overflow-hidden mb-0" style="background-color: #ffffff; border-radius: 0.75rem;">
          <thead style="background-color:#e0f2f1;">
            <tr class="text-center fw-semibold" style="color: #004d40;">
              <th>รหัส</th>
              <th>ชื่อโรงพยาบาล</th>
              <th>Visit</th>
            </tr>
          </thead>
          <tbody>
            @foreach($hospitalSummary as $h)
              <tr>
                <td align="right" class="text-secondary">{{ $h->hospcode }}</td>
                <td>
                  <span class="fw-semibold text-dark">{{ $h->hospname }}</span><br>
                  <small class="text-muted">
                    {{ $h->last_updated_at ? \Carbon\Carbon::parse($h->last_updated_at)->locale('th')->isoFormat('D MMM YYYY H:mm') . ' น.' : 'ยังไม่มีข้อมูลส่ง' }}
                  </small>
                </td>
                <td align="right" class="fw-bold" style="color:#26a69a;">{{ number_format($h->visit_healthmed) }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="modal-footer" style="background-color:#eef4fb;">
        <button type="button" class="btn btn-secondary rounded-pill px-4 shadow-sm" data-bs-dismiss="modal">ปิด</button>
      </div>
    </div>
  </div>
</div>

{{-- 6. การแพทย์ทางไกล วันนี้ --}}
<div class="modal fade" id="TeleDetailModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content border-0 shadow-lg rounded-3" style="background-color:#f5f8fc;">
      <div class="modal-header text-white rounded-top-3" style="background: linear-gradient(135deg, #26c6da, #4dd0e1);">
        <h5 class="modal-title fw-bold">
          <i class="fa-solid fa-video me-2"></i> การแพทย์ทางไกล (Telehealth) วันนี้
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body py-3">
        <table class="table table-hover align-middle shadow-sm rounded-3 overflow-hidden mb-0" style="background-color: #ffffff; border-radius: 0.75rem;">
          <thead style="background-color:#e0f7fa;">
            <tr class="text-center fw-semibold" style="color: #006064;">
              <th>รหัส</th>
              <th>ชื่อโรงพยาบาล</th>
              <th>Visit</th>
            </tr>
          </thead>
          <tbody>
            @foreach($hospitalSummary as $h)
              <tr>
                <td align="right" class="text-secondary">{{ $h->hospcode }}</td>
                <td>
                  <span class="fw-semibold text-dark">{{ $h->hospname }}</span><br>
                  <small class="text-muted">
                    {{ $h->last_updated_at ? \Carbon\Carbon::parse($h->last_updated_at)->locale('th')->isoFormat('D MMM YYYY H:mm') . ' น.' : 'ยังไม่มีข้อมูลส่ง' }}
                  </small>
                </td>
                <td align="right" class="fw-bold" style="color:#26c6da;">{{ number_format($h->visit_telehealth) }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="modal-footer" style="background-color:#eef4fb;">
        <button type="button" class="btn btn-secondary rounded-pill px-4 shadow-sm" data-bs-dismiss="modal">ปิด</button>
      </div>
    </div>
  </div>
</div>

{{-- 7. นัดหมายออนไลน์ วันนี้ --}}
<div class="modal fade" id="OappDetailModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content border-0 shadow-lg rounded-3" style="background-color:#f5f8fc;">
      <div class="modal-header text-white rounded-top-3" style="background: linear-gradient(135deg, #66bb6a, #81c784);">
        <h5 class="modal-title fw-bold">
          <i class="fa-solid fa-calendar-days me-2"></i> นัดหมายออนไลน์ (MOPH OApp) วันนี้
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body py-3">
        <table class="table table-hover align-middle shadow-sm rounded-3 overflow-hidden mb-0" style="background-color: #ffffff; border-radius: 0.75rem;">
          <thead style="background-color:#e8f5e9;">
            <tr class="text-center fw-semibold" style="color: #1b5e20;">
              <th>รหัส</th>
              <th>ชื่อโรงพยาบาล</th>
              <th>จองคิวนัดหมาย</th>
              <th>เข้ารับบริการ</th>
            </tr>
          </thead>
          <tbody>
            @foreach($hospitalSummary as $h)
              <tr>
                <td align="right" class="text-secondary">{{ $h->hospcode }}</td>
                <td>
                  <span class="fw-semibold text-dark">{{ $h->hospname }}</span><br>
                  <small class="text-muted">
                    {{ $h->last_updated_at ? \Carbon\Carbon::parse($h->last_updated_at)->locale('th')->isoFormat('D MMM YYYY H:mm') . ' น.' : 'ยังไม่มีข้อมูลส่ง' }}
                  </small>
                </td>
                <td align="right" class="fw-bold text-success">{{ number_format($h->visit_moph_oapp_booking) }}</td>
                <td align="right" class="fw-bold text-primary">{{ number_format($h->visit_moph_oapp) }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="modal-footer" style="background-color:#eef4fb;">
        <button type="button" class="btn btn-secondary rounded-pill px-4 shadow-sm" data-bs-dismiss="modal">ปิด</button>
      </div>
    </div>
  </div>
</div>
