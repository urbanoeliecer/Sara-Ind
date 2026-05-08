<form method="POST">
    Fecha inicio:
    <input type="date" name="fecha_inicio" value="<?= $fchInc ?>">
    Fecha fin:
    <input type="date" name="fecha_fin" value="<?= $fchFin ?>">
    Departamento:
    <select name="iddpt" onchange="this.form.submit()">
        <option value="">Todos</option>
        <?php foreach ($departamentos as $d): ?>
            <option value="<?= $d['idspr'] ?>"
                <?= ($iddpt == $d['idspr']) ? 'selected' : '' ?>>
                <?= $d['name'] ?>
            </option>
        <?php endforeach; ?>
    </select>
    Municipio:
    <select name="idmnc">
        <option value="">Todos</option>
        <?php foreach ($municipios as $m): ?>
            <option value="<?= $m['idsst'] ?>"
                <?= ($idmnc == $m['idsst']) ? 'selected' : '' ?>>
                <?= $m['name'] ?>
            </option>
        <?php endforeach; ?>
    </select>
    Página:
    <select name="pagina">
        <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
            <option value="<?= $i ?>" <?= ($pgn == $i) ? 'selected' : '' ?>>
                <?= $i ?>
            </option>
        <?php endfor; ?>
    </select>

    <button type="submit">Consultar</button>

</form>