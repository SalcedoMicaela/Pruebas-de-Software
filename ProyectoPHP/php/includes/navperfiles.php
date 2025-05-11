<ul>
    <?php if (in_array('reportes', $accesos)) : ?>
        <li class="nav-item"><a href="./reportes.php" class="nav-link px-2 link-body-emphasis">Reportes</a></li>
    <?php endif; ?>

    <?php if (in_array('inventario', $accesos)) : ?>
        <li class="nav-item"><a href="./inventario.php" class="nav-link px-2 link-body-emphasis">Inventario</a></li>
    <?php endif; ?>

    <?php if (in_array('ventas', $accesos)) : ?>
        <li class="nav-item"><a href="./ventas.php" class="nav-link px-2 link-body-emphasis">Ventas</a></li>
    <?php endif; ?>

    <?php if (in_array('usuarios', $accesos)) : ?>
        <li class="nav-item"><a href="./usuarios.php" class="nav-link px-2 link-body-emphasis">Usuarios</a></li>
    <?php endif; ?>

    <?php if (in_array('clientes', $accesos)) : ?>
        <li class="nav-item"><a href="./clientes.php" class="nav-link px-2 link-body-emphasis">Clientes</a></li>
    <?php endif; ?>
</ul>
