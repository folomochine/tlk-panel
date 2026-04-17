<?php include 'header.php'; ?>
<?php
if (route(1) == '2fa' && $settings['admin_2factor'] == 1) {
  if ($user['two_factor'] == 1) {
    if ($_POST) {
      foreach ($_POST as $key => $value) {
        $_SESSION['data'][$key] = htmlspecialchars(trim($value));
      }
      $edit = $conn->prepare('UPDATE admins SET two_factor=:two_factor WHERE admin_id=:id ');
      $edit->execute(array('id' => $user['admin_id'], 'two_factor' => 2));
      header('Location:' . site_url('admin'));
    }
  } elseif ($user['two_factor'] == 2) {
    if ($_POST) {
      foreach ($_POST as $key => $value) {
        $_SESSION['data'][$key] = htmlspecialchars(trim($value));
      }
      $edit = $conn->prepare('UPDATE admins SET two_factor=:two_factor WHERE admin_id=:id ');
      $edit->execute(array('id' => $user['admin_id'], 'two_factor' => 1));
      header('Location:' . site_url('admin'));
    }
  }
}

$fetchValue = function ($sql, $params = array()) use ($conn) {
  $st = $conn->prepare($sql); $st->execute($params);
  $v = $st->fetchColumn(); return $v === false || $v === null ? 0 : $v;
};
$fetchRows = function ($sql, $params = array()) use ($conn) {
  $st = $conn->prepare($sql); $st->execute($params);
  return $st->fetchAll(PDO::FETCH_ASSOC);
};

$baseCurrency = strtoupper($settings['site_base_currency'] ?? 'USD');
$currenciesArray = function_exists('get_currencies_array') ? get_currencies_array('all', 'currency_code') : array();
$rate = 10000;
if ($baseCurrency === 'GNF') { $rate = 1; }
elseif ($baseCurrency !== 'USD' && !empty($currenciesArray) && function_exists('from_to')) {
  $r = from_to($currenciesArray, $baseCurrency, 'GNF', 1);
  if ($r > 0) { $rate = $r; }
}
$toGnf     = function ($a) use ($rate) { return round((float) $a * (float) $rate, 0); };
$formatGnf = function ($a) { return number_format((float) $a, 0, ',', ' ') . ' GNF'; };

$statusLabel = function ($s) {
  $m = array('1' => 'En attente', '2' => 'Echoue', '3' => 'Valide');
  return $m[(string) $s] ?? 'Inconnu';
};
$statusCss = function ($s) {
  $s = (string) $s;
  if ($s === '3') return 'ok';
  if ($s === '1') return 'warn';
  return 'ko';
};

$monthStart = date('Y-m-01 00:00:00');
$monthEnd   = date('Y-m-t 23:59:59');
$monthNames = array(1=>'Janvier',2=>'Fevrier',3=>'Mars',4=>'Avril',5=>'Mai',6=>'Juin',7=>'Juillet',8=>'Aout',9=>'Septembre',10=>'Octobre',11=>'Novembre',12=>'Decembre');
$currentMonthLabel = ($monthNames[(int) date('n')] ?? date('F')) . ' ' . date('Y');
$dayMap = array('Mon'=>'LUN','Tue'=>'MAR','Wed'=>'MER','Thu'=>'JEU','Fri'=>'VEN','Sat'=>'SAM','Sun'=>'DIM');

$totalClients     = (int) $fetchValue("SELECT COUNT(*) FROM clients WHERE client_type='2'");
$pendingOrders    = (int) $fetchValue("SELECT COUNT(*) FROM orders WHERE order_status='pending'");
$processingOrders = (int) $fetchValue("SELECT COUNT(*) FROM orders WHERE order_status='processing'");
$inprogressOrders = (int) $fetchValue("SELECT COUNT(*) FROM orders WHERE order_status='inprogress'");
$completedOrders  = (int) $fetchValue("SELECT COUNT(*) FROM orders WHERE order_status='completed'");
$partialOrders    = (int) $fetchValue("SELECT COUNT(*) FROM orders WHERE order_status='partial'");
$canceledOrders   = (int) $fetchValue("SELECT COUNT(*) FROM orders WHERE order_status='canceled'");
$pendingPayments  = (int) $fetchValue("SELECT COUNT(*) FROM payments WHERE payment_status='1'");
$openTickets      = (int) $fetchValue("SELECT COUNT(*) FROM tickets WHERE client_new='2'");
$totalServices    = (int) $fetchValue("SELECT COUNT(*) FROM services");

$activeOrders   = $processingOrders + $inprogressOrders;
$rejectedOrders = $canceledOrders + $partialOrders;

$totalDepositsBase      = (float) $fetchValue("SELECT COALESCE(SUM(payment_amount),0) FROM payments WHERE payment_status='3' AND payment_delivery='2'");
$totalClientBalanceBase = (float) $fetchValue("SELECT COALESCE(SUM(balance),0) FROM clients WHERE client_type='2'");
$totalSpentBase         = (float) $fetchValue("SELECT COALESCE(SUM(order_charge),0) FROM orders");
$totalProfitBase        = (float) $fetchValue("SELECT COALESCE(SUM(order_profit),0) FROM orders");

$monthDepositsBase = (float) $fetchValue(
  "SELECT COALESCE(SUM(payment_amount),0) FROM payments WHERE payment_status='3' AND payment_delivery='2' AND payment_create_date >= :s AND payment_create_date <= :e",
  array('s' => $monthStart, 'e' => $monthEnd)
);
$monthSpentBase = (float) $fetchValue(
  "SELECT COALESCE(SUM(order_charge),0) FROM orders WHERE order_create >= :s AND order_create <= :e",
  array('s' => $monthStart, 'e' => $monthEnd)
);
$monthProfitBase = (float) $fetchValue(
  "SELECT COALESCE(SUM(order_profit),0) FROM orders WHERE order_create >= :s AND order_create <= :e",
  array('s' => $monthStart, 'e' => $monthEnd)
);
$monthNewClients = (int) $fetchValue(
  'SELECT COUNT(*) FROM clients WHERE register_date >= :s AND register_date <= :e',
  array('s' => $monthStart, 'e' => $monthEnd)
);
$monthCompletedOrders = (int) $fetchValue(
  "SELECT COUNT(*) FROM orders WHERE order_status='completed' AND order_create >= :s AND order_create <= :e",
  array('s' => $monthStart, 'e' => $monthEnd)
);

$days = array();
for ($i = 6; $i >= 0; $i--) {
  $d = date('Y-m-d', strtotime("-$i days"));
  $start = $d . ' 00:00:00';
  $end   = $d . ' 23:59:59';
  $dayDeposit = (float) $fetchValue(
    "SELECT COALESCE(SUM(payment_amount),0) FROM payments WHERE payment_status='3' AND payment_delivery='2' AND payment_create_date >= :s AND payment_create_date <= :e",
    array('s' => $start, 'e' => $end)
  );
  $daySpent = (float) $fetchValue(
    "SELECT COALESCE(SUM(order_charge),0) FROM orders WHERE order_create >= :s AND order_create <= :e",
    array('s' => $start, 'e' => $end)
  );
  $en = date('D', strtotime($d));
  $days[] = array(
    'label'   => $dayMap[$en] ?? strtoupper(substr($en, 0, 3)),
    'date'    => date('d/m', strtotime($d)),
    'deposit' => $toGnf($dayDeposit),
    'spent'   => $toGnf($daySpent),
  );
}
$maxDay = 1;
foreach ($days as $dd) {
  if ($dd['deposit'] > $maxDay) $maxDay = $dd['deposit'];
  if ($dd['spent'] > $maxDay)   $maxDay = $dd['spent'];
}

$waitingOrders = $pendingOrders;
$donutSegments = array(
  array('label' => 'Terminees', 'value' => $completedOrders, 'color' => '#10B981'),
  array('label' => 'En cours',  'value' => $activeOrders,    'color' => '#6366F1'),
  array('label' => 'En attente','value' => $waitingOrders,   'color' => '#F59E0B'),
  array('label' => 'Rejetees',  'value' => $rejectedOrders,  'color' => '#EF4444'),
);
$donutTotal = array_sum(array_column($donutSegments, 'value'));
if ($donutTotal === 0) { $donutTotal = 1; }
$donutCircum = 2 * M_PI * 60;
$donutOffset = 0;

$recentPayments = $fetchRows(
  "SELECT p.payment_id, p.payment_status, p.payment_amount, p.payment_create_date, p.payment_method, p.payment_mode, c.username,
          pm.methodVisibleName, pm.methodName
   FROM payments p
   LEFT JOIN clients c ON c.client_id = p.client_id
   LEFT JOIN paymentmethods pm ON pm.methodId = p.payment_method
   ORDER BY p.payment_id DESC
   LIMIT 6"
);

$paymentModeFor = function ($p) {
  $mid   = isset($p['payment_method']) ? (int) $p['payment_method'] : 0;
  $mode  = isset($p['payment_mode']) ? strtolower((string) $p['payment_mode']) : '';
  $name  = trim((string) ($p['methodVisibleName'] ?? ''));
  if ($name === '') { $name = trim((string) ($p['methodName'] ?? '')); }
  if ($mid === 0 || $mode === 'manual' || $mid >= 100) {
    return array('label' => 'Manuel', 'kind' => 'manuel');
  }
  if ($mid === 21) {
    return array('label' => 'Orange Money', 'kind' => 'orange');
  }
  return array('label' => $name !== '' ? $name : 'Auto', 'kind' => 'auto');
};

$twoFactorEnabled = (isset($admin['two_factor']) && (int) $admin['two_factor'] === 1);
?>

<style>
.tl-board {
  --b-card: var(--card, #ffffff);
  --b-border: var(--border, #e2e8f0);
  --b-text: var(--text, #0f172a);
  --b-muted: var(--muted, #64748b);
  --b-shadow: 0 10px 28px rgba(15,23,42,.06);
  color: var(--b-text);
  font-size: 14px;
}
body.dark-mode .tl-board {
  --b-shadow: 0 14px 30px rgba(2,6,23,.45);
}

.tl-board .hero {
  display: grid;
  grid-template-columns: minmax(0, 1fr) auto;
  gap: 16px;
  align-items: center;
  padding: 22px 24px;
  border-radius: 18px;
  background: var(--b-card);
  border: 1px solid var(--b-border);
  box-shadow: var(--b-shadow);
  margin-bottom: 20px;
  position: relative;
  overflow: hidden;
}
.tl-board .hero::before {
  content: "";
  position: absolute; inset: 0;
  background:
    radial-gradient(600px 200px at -10% -30%, rgba(99,102,241,.18), transparent 60%),
    radial-gradient(500px 220px at 110% 130%, rgba(16,185,129,.14), transparent 60%);
  pointer-events: none;
}
.tl-board .hero > * { position: relative; z-index: 1; }
.tl-board .hero .hero-left { display: flex; align-items: center; gap: 14px; }
.tl-board .hero .hero-ico {
  width: 48px; height: 48px; border-radius: 14px;
  background: linear-gradient(135deg, #6366F1, #06B6D4);
  display: inline-flex; align-items: center; justify-content: center;
  color: #fff; font-size: 20px;
  box-shadow: 0 12px 24px rgba(99,102,241,.35);
}
.tl-board .hero h1 {
  margin: 0; font-size: 22px; font-weight: 800; letter-spacing: -.01em;
  color: var(--b-text);
}
.tl-board .hero .hero-sub {
  margin-top: 2px; color: var(--b-muted); font-size: 13px;
}
.tl-board .hero .hero-actions {
  display: flex; gap: 10px; flex-wrap: wrap; justify-content: flex-end;
}
.tl-board .hero .btn-pill {
  display: inline-flex; align-items: center; gap: 8px;
  padding: 10px 14px; border-radius: 12px; font-weight: 700; font-size: 13px;
  background: var(--b-card); color: var(--b-text); text-decoration: none;
  border: 1px solid var(--b-border);
  transition: transform .15s ease, border-color .15s ease;
}
.tl-board .hero .btn-pill i { opacity: .9; }
.tl-board .hero .btn-pill:hover { transform: translateY(-1px); border-color: rgba(99,102,241,.35); }
.tl-board .hero .btn-pill.primary {
  background: linear-gradient(135deg,#6366F1,#3B82F6); color: #fff; border-color: transparent;
  box-shadow: 0 10px 22px rgba(99,102,241,.35);
}
.tl-board .hero .btn-pill.success {
  background: linear-gradient(135deg,#34D399,#22D3EE); color: #062e2a; border-color: transparent;
  box-shadow: 0 10px 22px rgba(52,211,153,.35);
}
.tl-board .hero .btn-pill.success:hover { filter: brightness(1.06); }
.tl-board .hero .btn-pill.danger {
  background: linear-gradient(135deg,#FB7185,#F97316); color: #fff; border-color: transparent;
  box-shadow: 0 10px 22px rgba(251,113,133,.35);
}
.tl-board .mode {
  display: inline-flex; align-items: center; gap: 6px;
  padding: 4px 10px; border-radius: 999px;
  font-size: 11px; font-weight: 800; letter-spacing: .03em;
  border: 1px solid var(--b-border);
}
.tl-board .mode.orange { background: rgba(249,115,22,.14); color: #c2410c; border-color: rgba(249,115,22,.25); }
.tl-board .mode.manuel { background: rgba(99,102,241,.14); color: #4338ca; border-color: rgba(99,102,241,.25); }
.tl-board .mode.auto   { background: rgba(16,185,129,.14); color: #047857; border-color: rgba(16,185,129,.25); }
.tl-board .mode .d { width: 6px; height: 6px; border-radius: 50%; display: inline-block; }
.tl-board .mode.orange .d { background: #F97316; }
.tl-board .mode.manuel .d { background: #6366F1; }
.tl-board .mode.auto   .d { background: #10B981; }
.tl-board .hero form.two-factor-form { margin: 0; }

.tl-board .kpi-grid {
  display: grid;
  grid-template-columns: repeat(4, minmax(0, 1fr));
  gap: 16px;
  margin-bottom: 20px;
}
.tl-board .kpi {
  display: flex; align-items: center; gap: 14px;
  padding: 18px 18px;
  background: var(--b-card);
  border: 1px solid var(--b-border);
  border-radius: 16px;
  box-shadow: var(--b-shadow);
  text-decoration: none; color: inherit;
  transition: transform .15s ease, box-shadow .15s ease;
}
.tl-board .kpi:hover { transform: translateY(-2px); box-shadow: 0 18px 36px rgba(15,23,42,.14); }
.tl-board .kpi .kico {
  width: 52px; height: 52px; border-radius: 14px; flex-shrink: 0;
  display: inline-flex; align-items: center; justify-content: center;
  font-size: 20px; color: #fff;
}
.tl-board .kpi .kinfo { min-width: 0; }
.tl-board .kpi .klabel {
  color: var(--b-muted); font-size: 11px; font-weight: 800;
  text-transform: uppercase; letter-spacing: .10em; line-height: 1;
}
.tl-board .kpi .kvalue {
  font-size: 28px; font-weight: 800; margin-top: 8px; line-height: 1;
}
.tl-board .kpi .khint {
  color: var(--b-muted); font-size: 12px; margin-top: 6px;
}
.tl-board .kpi.orange .kico  { background: linear-gradient(135deg,#F59E0B,#FB923C); box-shadow: 0 10px 22px rgba(245,158,11,.25); }
.tl-board .kpi.blue   .kico  { background: linear-gradient(135deg,#3B82F6,#6366F1); box-shadow: 0 10px 22px rgba(59,130,246,.25); }
.tl-board .kpi.green  .kico  { background: linear-gradient(135deg,#10B981,#059669); box-shadow: 0 10px 22px rgba(16,185,129,.25); }
.tl-board .kpi.red    .kico  { background: linear-gradient(135deg,#EF4444,#DC2626); box-shadow: 0 10px 22px rgba(239,68,68,.25); }
.tl-board .kpi.orange .kvalue { color: #F59E0B; }
.tl-board .kpi.blue   .kvalue { color: #3B82F6; }
.tl-board .kpi.green  .kvalue { color: #10B981; }
.tl-board .kpi.red    .kvalue { color: #EF4444; }

.tl-board .row-2 {
  display: grid;
  grid-template-columns: minmax(0, 1.6fr) minmax(320px, 1fr);
  gap: 18px;
  margin-bottom: 20px;
}
.tl-board .panel {
  background: var(--b-card);
  border: 1px solid var(--b-border);
  border-radius: 16px;
  padding: 20px 22px;
  box-shadow: var(--b-shadow);
}
.tl-board .panel-head {
  display: flex; justify-content: space-between; align-items: center;
  gap: 10px; margin-bottom: 14px;
}
.tl-board .panel-head h2 {
  margin: 0; font-size: 15px; font-weight: 800; color: var(--b-text);
  display: inline-flex; align-items: center; gap: 10px;
}
.tl-board .panel-head h2 .pico {
  width: 32px; height: 32px; border-radius: 10px; font-size: 13px;
  display: inline-flex; align-items: center; justify-content: center;
  color: #fff;
}
.tl-board .panel-head .legend { display: flex; gap: 12px; font-size: 12px; color: var(--b-muted); }
.tl-board .panel-head .legend span { display: inline-flex; align-items: center; gap: 6px; }
.tl-board .panel-head .legend i { width: 10px; height: 10px; border-radius: 3px; display: inline-block; }
.tl-board .panel-head a.link { color: #3B82F6; text-decoration: none; font-weight: 700; font-size: 12px; }

.tl-board .chart {
  display: grid;
  grid-template-columns: repeat(7, 1fr);
  gap: 10px;
  align-items: end;
  height: 220px;
  padding: 6px 4px 0;
}
.tl-board .chart .col { display: flex; flex-direction: column; align-items: center; gap: 6px; height: 100%; }
.tl-board .chart .bars { display: flex; align-items: flex-end; gap: 4px; width: 100%; height: 100%; justify-content: center; }
.tl-board .chart .bar {
  width: 14px; border-radius: 8px 8px 4px 4px; min-height: 4px;
  box-shadow: inset 0 1px 0 rgba(255,255,255,.3);
  transition: transform .15s ease;
}
.tl-board .chart .bar:hover { transform: scaleY(1.03); }
.tl-board .chart .bar.dep { background: linear-gradient(180deg,#6366F1,#3B82F6); }
.tl-board .chart .bar.spn { background: linear-gradient(180deg,#F59E0B,#F43F5E); }
.tl-board .chart .day { font-size: 11px; font-weight: 800; color: var(--b-muted); letter-spacing: .04em; }

.tl-board .donut-wrap { display: flex; align-items: center; gap: 18px; flex-wrap: wrap; }
.tl-board .donut { position: relative; flex-shrink: 0; }
.tl-board .donut-center {
  position: absolute; inset: 0; display: flex; flex-direction: column;
  align-items: center; justify-content: center; text-align: center;
}
.tl-board .donut-center strong { font-size: 24px; font-weight: 800; color: var(--b-text); line-height: 1; }
.tl-board .donut-center span   { color: var(--b-muted); font-size: 11px; margin-top: 4px; }
.tl-board .donut-legend { flex: 1 1 160px; display: grid; gap: 8px; }
.tl-board .donut-legend .row {
  display: flex; justify-content: space-between; align-items: center; gap: 10px;
  font-size: 13px;
}
.tl-board .donut-legend .dot { width: 10px; height: 10px; border-radius: 3px; display: inline-block; margin-right: 8px; }
.tl-board .donut-legend .lbl { color: var(--b-text); font-weight: 700; }
.tl-board .donut-legend .num { color: var(--b-muted); font-weight: 700; }

.tl-board table.tbl { width: 100%; border-collapse: collapse; }
.tl-board table.tbl th, .tl-board table.tbl td {
  padding: 12px 0; text-align: left;
  border-bottom: 1px solid var(--b-border); font-size: 14px;
}
.tl-board table.tbl tr:last-child td { border-bottom: 0; }
.tl-board table.tbl th {
  font-size: 11px; font-weight: 800; letter-spacing: .06em;
  color: var(--b-muted); text-transform: uppercase;
}
.tl-board table.tbl td.right, .tl-board table.tbl th.right { text-align: right; }
.tl-board table.tbl .cell-ico {
  width: 28px; height: 28px; border-radius: 9px;
  display: inline-flex; align-items: center; justify-content: center;
  margin-right: 8px; color: #fff; font-size: 12px; vertical-align: middle;
}

.tl-board .pill2 {
  display: inline-block; padding: 4px 10px; border-radius: 999px;
  font-size: 11px; font-weight: 800; letter-spacing: .03em;
  border: 1px solid transparent;
}
.tl-board .pill2.ok   { background: rgba(16,185,129,.14); color: #047857; border-color: rgba(16,185,129,.24); }
.tl-board .pill2.warn { background: rgba(245,158,11,.16); color: #b45309; border-color: rgba(245,158,11,.28); }
.tl-board .pill2.ko   { background: rgba(239,68,68,.12);  color: #b91c1c; border-color: rgba(239,68,68,.24); }

.tl-board .quick {
  display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 12px; margin-top: 4px;
}
.tl-board .quick a {
  display: flex; align-items: center; gap: 12px;
  padding: 14px; border-radius: 14px;
  background: var(--b-card); border: 1px solid var(--b-border);
  text-decoration: none; color: var(--b-text); font-weight: 700;
  transition: transform .15s ease, border-color .15s ease;
}
.tl-board .quick a:hover { transform: translateX(2px); border-color: rgba(99,102,241,.35); }
.tl-board .quick a i {
  width: 38px; height: 38px; border-radius: 11px; display: inline-flex;
  align-items: center; justify-content: center; color: #fff; font-size: 14px;
}
.tl-board .quick a.q1 i { background: linear-gradient(135deg,#6366F1,#3B82F6); }
.tl-board .quick a.q2 i { background: linear-gradient(135deg,#10B981,#059669); }
.tl-board .quick a.q3 i { background: linear-gradient(135deg,#F59E0B,#FB923C); }
.tl-board .quick a.q4 i { background: linear-gradient(135deg,#EC4899,#8B5CF6); }

@media (max-width: 1199px) {
  .tl-board .kpi-grid, .tl-board .quick { grid-template-columns: repeat(2, minmax(0, 1fr)); }
  .tl-board .row-2 { grid-template-columns: 1fr; }
  .tl-board .hero  { grid-template-columns: 1fr; }
  .tl-board .hero .hero-actions { justify-content: flex-start; }
}
@media (max-width: 640px) {
  .tl-board .kpi-grid, .tl-board .quick { grid-template-columns: 1fr; }
  .tl-board .chart .bar { width: 10px; }
  .tl-board .kpi .kvalue { font-size: 24px; }
}
</style>

<div class="tl-board">

  <div class="hero">
    <div class="hero-left">
      <div class="hero-ico"><i class="fa fa-tachometer-alt"></i></div>
      <div>
        <h1>Tableau de bord</h1>
        <div class="hero-sub"><?= $currentMonthLabel; ?> &middot; Vue d'ensemble de l'activite</div>
      </div>
    </div>
    <div class="hero-actions">
      <?php if ($twoFactorEnabled): ?>
        <form class="two-factor-form" method="POST" action="<?= site_url('admin/2fa'); ?>">
          <?php if (function_exists('csrf_field')) { echo csrf_field(); } ?>
          <button type="submit" class="btn-pill danger">
            <i class="fa fa-shield-alt"></i>
            Desactiver la 2FA
          </button>
        </form>
      <?php else: ?>
        <a class="btn-pill success" href="<?= site_url('admin/activate-google-2fa'); ?>">
          <i class="fa fa-shield-alt"></i>
          Activer la 2FA
        </a>
      <?php endif; ?>
      <a class="btn-pill" href="<?= site_url('admin/orders'); ?>">
        <i class="fa fa-shopping-cart"></i>
        Commandes
      </a>
      <a class="btn-pill" href="<?= site_url('admin/fund-add-history'); ?>">
        <i class="fa fa-wallet"></i>
        Paiements
      </a>
    </div>
  </div>

  <div class="kpi-grid">
    <a class="kpi orange" href="<?= site_url('admin/orders/1/pending'); ?>">
      <span class="kico"><i class="fa fa-hourglass-half"></i></span>
      <div class="kinfo">
        <div class="klabel">En attente</div>
        <div class="kvalue"><?= number_format($pendingOrders, 0, ',', ' '); ?></div>
        <div class="khint">Commandes a traiter</div>
      </div>
    </a>
    <a class="kpi blue" href="<?= site_url('admin/orders/1/inprogress'); ?>">
      <span class="kico"><i class="fa fa-sync-alt"></i></span>
      <div class="kinfo">
        <div class="klabel">En cours</div>
        <div class="kvalue"><?= number_format($activeOrders, 0, ',', ' '); ?></div>
        <div class="khint">Traitement + progression</div>
      </div>
    </a>
    <a class="kpi green" href="<?= site_url('admin/orders/1/completed'); ?>">
      <span class="kico"><i class="fa fa-check-circle"></i></span>
      <div class="kinfo">
        <div class="klabel">Terminees</div>
        <div class="kvalue"><?= number_format($completedOrders, 0, ',', ' '); ?></div>
        <div class="khint">Commandes livrees</div>
      </div>
    </a>
    <a class="kpi red" href="<?= site_url('admin/orders/1/canceled'); ?>">
      <span class="kico"><i class="fa fa-times-circle"></i></span>
      <div class="kinfo">
        <div class="klabel">Rejetees</div>
        <div class="kvalue"><?= number_format($rejectedOrders, 0, ',', ' '); ?></div>
        <div class="khint">Annulees + partielles</div>
      </div>
    </a>
  </div>

  <div class="row-2">
    <div class="panel">
      <div class="panel-head">
        <h2>
          <span class="pico" style="background:linear-gradient(135deg,#6366F1,#3B82F6);"><i class="fa fa-chart-bar"></i></span>
          Flux des 7 derniers jours
        </h2>
        <div class="legend">
          <span><i style="background:#6366F1;"></i> Recharges</span>
          <span><i style="background:#F59E0B;"></i> Depenses</span>
        </div>
      </div>
      <div class="chart">
        <?php foreach ($days as $d): ?>
          <?php
            $hDep = max(4, (int) round(($d['deposit'] / $maxDay) * 190));
            $hSpn = max(4, (int) round(($d['spent']   / $maxDay) * 190));
          ?>
          <div class="col">
            <div class="bars">
              <div class="bar dep" style="height: <?= $hDep; ?>px;" title="Recharges <?= $formatGnf($d['deposit']); ?>"></div>
              <div class="bar spn" style="height: <?= $hSpn; ?>px;" title="Depenses <?= $formatGnf($d['spent']); ?>"></div>
            </div>
            <div class="day"><?= $d['label']; ?></div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="panel">
      <div class="panel-head">
        <h2>
          <span class="pico" style="background:linear-gradient(135deg,#10B981,#059669);"><i class="fa fa-chart-pie"></i></span>
          Repartition des commandes
        </h2>
      </div>
      <div class="donut-wrap">
        <div class="donut">
          <svg width="150" height="150" viewBox="0 0 150 150">
            <circle cx="75" cy="75" r="60" fill="none" stroke="var(--b-border)" stroke-width="18"></circle>
            <?php foreach ($donutSegments as $seg):
              if ($seg['value'] <= 0) continue;
              $len = ($seg['value'] / $donutTotal) * $donutCircum;
              $dashArray = $len . ' ' . ($donutCircum - $len);
              $dashOffset = -$donutOffset;
              $donutOffset += $len;
            ?>
              <circle cx="75" cy="75" r="60" fill="none"
                stroke="<?= $seg['color']; ?>" stroke-width="18"
                stroke-dasharray="<?= $dashArray; ?>"
                stroke-dashoffset="<?= $dashOffset; ?>"
                transform="rotate(-90 75 75)"
                stroke-linecap="butt"></circle>
            <?php endforeach; ?>
          </svg>
          <div class="donut-center">
            <strong><?= number_format($donutTotal, 0, ',', ' '); ?></strong>
            <span>Commandes</span>
          </div>
        </div>
        <div class="donut-legend">
          <?php foreach ($donutSegments as $seg):
            $pct = $donutTotal > 0 ? round(($seg['value'] / $donutTotal) * 100) : 0;
          ?>
            <div class="row">
              <span><span class="dot" style="background: <?= $seg['color']; ?>;"></span><span class="lbl"><?= $seg['label']; ?></span></span>
              <span class="num"><?= number_format($seg['value'], 0, ',', ' '); ?> &middot; <?= $pct; ?>%</span>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>

  <div class="row-2">
    <div class="panel">
      <div class="panel-head">
        <h2>
          <span class="pico" style="background:linear-gradient(135deg,#F59E0B,#FB923C);"><i class="fa fa-coins"></i></span>
          Situation financiere
        </h2>
        <a class="link" href="<?= site_url('admin/fund-add-history'); ?>">Historique &rarr;</a>
      </div>
      <table class="tbl">
        <thead>
          <tr>
            <th>Indicateur</th>
            <th class="right">Montant GNF</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><span class="cell-ico" style="background:linear-gradient(135deg,#10B981,#059669);"><i class="fa fa-arrow-down"></i></span>Recharges validees</td>
            <td class="right"><strong style="color:#10B981;"><?= $formatGnf($toGnf($totalDepositsBase)); ?></strong></td>
          </tr>
          <tr>
            <td><span class="cell-ico" style="background:linear-gradient(135deg,#3B82F6,#6366F1);"><i class="fa fa-wallet"></i></span>Solde total clients</td>
            <td class="right"><strong style="color:#3B82F6;"><?= $formatGnf($toGnf($totalClientBalanceBase)); ?></strong></td>
          </tr>
          <tr>
            <td><span class="cell-ico" style="background:linear-gradient(135deg,#F59E0B,#FB923C);"><i class="fa fa-arrow-up"></i></span>Depenses commandes</td>
            <td class="right"><strong style="color:#F59E0B;"><?= $formatGnf($toGnf($totalSpentBase)); ?></strong></td>
          </tr>
          <tr>
            <td><span class="cell-ico" style="background:linear-gradient(135deg,#8B5CF6,#EC4899);"><i class="fa fa-chart-line"></i></span>Profit estime</td>
            <td class="right"><strong style="color:#8B5CF6;"><?= $formatGnf($toGnf($totalProfitBase)); ?></strong></td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="panel">
      <div class="panel-head">
        <h2>
          <span class="pico" style="background:linear-gradient(135deg,#EC4899,#8B5CF6);"><i class="fa fa-calendar-check"></i></span>
          Activite du mois
        </h2>
      </div>
      <table class="tbl">
        <tbody>
          <tr><td>Recharges</td><td class="right"><strong><?= $formatGnf($toGnf($monthDepositsBase)); ?></strong></td></tr>
          <tr><td>Depenses</td><td class="right"><strong><?= $formatGnf($toGnf($monthSpentBase)); ?></strong></td></tr>
          <tr><td>Profit</td><td class="right"><strong><?= $formatGnf($toGnf($monthProfitBase)); ?></strong></td></tr>
          <tr><td>Commandes terminees</td><td class="right"><strong><?= number_format($monthCompletedOrders, 0, ',', ' '); ?></strong></td></tr>
          <tr><td>Nouveaux clients</td><td class="right"><strong><?= number_format($monthNewClients, 0, ',', ' '); ?></strong></td></tr>
        </tbody>
      </table>
    </div>
  </div>

  <div class="row-2">
    <div class="panel">
      <div class="panel-head">
        <h2>
          <span class="pico" style="background:linear-gradient(135deg,#3B82F6,#06B6D4);"><i class="fa fa-receipt"></i></span>
          Dernieres transactions
        </h2>
        <a class="link" href="<?= site_url('admin/fund-add-history'); ?>">Tout voir &rarr;</a>
      </div>
      <table class="tbl">
        <thead>
          <tr>
            <th>Client</th>
            <th>Mode</th>
            <th>Date</th>
            <th class="right">Montant</th>
            <th class="right">Statut</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($recentPayments)): ?>
            <?php foreach ($recentPayments as $p): $mode = $paymentModeFor($p); ?>
              <tr>
                <td><span class="cell-ico" style="background:linear-gradient(135deg,#6366F1,#3B82F6);"><i class="fa fa-user"></i></span><?= $p['username'] ? htmlspecialchars($p['username']) : 'Client supprime'; ?></td>
                <td><span class="mode <?= $mode['kind']; ?>"><span class="d"></span><?= htmlspecialchars($mode['label']); ?></span></td>
                <td style="color:var(--b-muted);"><?= $p['payment_create_date'] ? date('d/m/Y H:i', strtotime($p['payment_create_date'])) : '-'; ?></td>
                <td class="right"><strong><?= $formatGnf($toGnf($p['payment_amount'])); ?></strong></td>
                <td class="right"><span class="pill2 <?= $statusCss($p['payment_status']); ?>"><?= $statusLabel($p['payment_status']); ?></span></td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr><td colspan="5" style="color:var(--b-muted);">Aucune transaction pour le moment.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <div class="panel">
      <div class="panel-head">
        <h2>
          <span class="pico" style="background:linear-gradient(135deg,#EF4444,#F43F5E);"><i class="fa fa-bell"></i></span>
          A verifier
        </h2>
      </div>
      <table class="tbl">
        <tbody>
          <tr>
            <td><span class="cell-ico" style="background:linear-gradient(135deg,#F59E0B,#FB923C);"><i class="fa fa-money-check-alt"></i></span>Paiements en attente</td>
            <td class="right"><strong><?= number_format($pendingPayments, 0, ',', ' '); ?></strong></td>
          </tr>
          <tr>
            <td><span class="cell-ico" style="background:linear-gradient(135deg,#3B82F6,#6366F1);"><i class="fa fa-life-ring"></i></span>Tickets non lus</td>
            <td class="right"><strong><?= number_format($openTickets, 0, ',', ' '); ?></strong></td>
          </tr>
          <tr>
            <td><span class="cell-ico" style="background:linear-gradient(135deg,#10B981,#059669);"><i class="fa fa-users"></i></span>Clients actifs</td>
            <td class="right"><strong><?= number_format($totalClients, 0, ',', ' '); ?></strong></td>
          </tr>
          <tr>
            <td><span class="cell-ico" style="background:linear-gradient(135deg,#8B5CF6,#EC4899);"><i class="fa fa-layer-group"></i></span>Services actifs</td>
            <td class="right"><strong><?= number_format($totalServices, 0, ',', ' '); ?></strong></td>
          </tr>
          <tr>
            <td><span class="cell-ico" style="background:linear-gradient(135deg,<?= $twoFactorEnabled ? '#10B981,#059669' : '#EF4444,#DC2626'; ?>);"><i class="fa fa-shield-alt"></i></span>Authentification 2FA</td>
            <td class="right"><span class="pill2 <?= $twoFactorEnabled ? 'ok' : 'ko'; ?>"><?= $twoFactorEnabled ? 'Activee' : 'Desactivee'; ?></span></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <div class="panel">
    <div class="panel-head">
      <h2>
        <span class="pico" style="background:linear-gradient(135deg,#8B5CF6,#EC4899);"><i class="fa fa-bolt"></i></span>
        Acces rapides
      </h2>
    </div>
    <div class="quick">
      <a class="q1" href="<?= site_url('admin/orders'); ?>"><i class="fa fa-shopping-cart"></i> Commandes</a>
      <a class="q2" href="<?= site_url('admin/clients'); ?>"><i class="fa fa-users"></i> Clients</a>
      <a class="q3" href="<?= site_url('admin/fund-add-history'); ?>"><i class="fa fa-wallet"></i> Paiements</a>
      <a class="q4" href="<?= site_url('admin/settings/paymentMethods'); ?>"><i class="fa fa-credit-card"></i> Moyens de paiement</a>
    </div>
  </div>

</div>

<?php include 'footer.php'; ?>
