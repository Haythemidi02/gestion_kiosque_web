<?php
require_once '../core/admin_functions.php';
include '../includes/admin/header.php';

$settings = getSettings();
$notification = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_settings'])) {
    foreach ($_POST['settings'] as $key => $value) {
        updateSetting($key, $value);
    }
    // Update specific settings that might be formatted differently
    if (isset($_POST['hours'])) {
        foreach ($_POST['hours'] as $day => $times) {
            updateSetting('hours_' . $day, $times['open'] . '-' . $times['close']);
        }
    }
    
    $_SESSION['notification'] = "Paramètres enregistrés avec succès !";
    header("Location: settings.php");
    exit;
}

$notification = isset($_SESSION['notification']) ? $_SESSION['notification'] : '';
unset($_SESSION['notification']);
?>

<div class="admin-content">
    <div class="section-title">
        <h2>Paramètres du Système</h2>
    </div>

    <?php if ($notification): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($notification); ?></div>
    <?php endif; ?>

    <form method="post" action="">
        <div class="settings-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 2rem;">
            <!-- Shop Info -->
            <div class="card">
                <div class="card-header"><h3>Informations du Kiosque</h3></div>
                <div class="form-group">
                    <label>Nom du kiosque</label>
                    <input type="text" name="settings[shop_name]" class="form-control" value="<?php echo htmlspecialchars($settings['shop_name'] ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label>Adresse</label>
                    <input type="text" name="settings[shop_address]" class="form-control" value="<?php echo htmlspecialchars($settings['shop_address'] ?? ''); ?>">
                </div>
                <div class="form-row">
                    <div class="form-col">
                        <label>Téléphone</label>
                        <input type="text" name="settings[shop_phone]" class="form-control" value="<?php echo htmlspecialchars($settings['shop_phone'] ?? ''); ?>">
                    </div>
                    <div class="form-col">
                        <label>Email</label>
                        <input type="email" name="settings[shop_email]" class="form-control" value="<?php echo htmlspecialchars($settings['shop_email'] ?? ''); ?>">
                    </div>
                </div>
            </div>

            <!-- Opening Hours -->
            <div class="card">
                <div class="card-header"><h3>Horaires d'ouverture</h3></div>
                <?php
                $days = ['monday' => 'Lundi', 'tuesday' => 'Mardi', 'wednesday' => 'Mercredi', 'thursday' => 'Jeudi', 'friday' => 'Vendredi', 'saturday' => 'Samedi', 'sunday' => 'Dimanche'];
                foreach ($days as $key => $name):
                    $hours = $settings['hours_'.$key] ?? '08:00-18:00';
                    $parts = explode('-', $hours);
                    $open = $parts[0] ?? '08:00';
                    $close = $parts[1] ?? '18:00';
                ?>
                <div class="form-row" style="margin-bottom: 0.5rem; align-items: center;">
                    <div style="flex: 1;"><?php echo $name; ?></div>
                    <div style="flex: 1;"><input type="time" name="hours[<?php echo $key; ?>][open]" class="form-control" value="<?php echo $open; ?>"></div>
                    <div style="padding: 0 0.5rem;">à</div>
                    <div style="flex: 1;"><input type="time" name="hours[<?php echo $key; ?>][close]" class="form-control" value="<?php echo $close; ?>"></div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="form-actions" style="margin-top: 2rem;">
            <button type="submit" name="save_settings" class="btn btn-success btn-lg">Enregistrer tous les paramètres</button>
        </div>
    </form>
</div>

<?php include '../includes/admin/footer.php'; ?>
