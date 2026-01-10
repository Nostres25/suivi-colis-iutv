<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

<style>

    /* Commandes */
        /* #orders {
            text-align:center
        } */

    /* Table: */

    table {
        border-collapse: collapse;
        border: 2px solid rgb(140 140 140);
        font-family: sans-serif;
        font-size: 0.8rem;
        letter-spacing: 1px;
        margin: 0px auto;
    }

    caption {
        caption-side: bottom;
        padding: 10px;
        font-weight: bold;
    }

    thead,
    tfoot {
        background-color: rgb(228 240 245);
    }

    th,
    td {
    border: 1px solid rgb(160 160 160);
    padding: 8px 10px;
    }

    td:last-of-type {
    text-align: center;
    }

    tbody > tr:nth-of-type(even) {
    background-color: rgb(237 238 242);
    }

    tfoot th {
    text-align: right;
    }

    tfoot td {
    font-weight: bold;
    }

    /* Search bar : */
    .search-container {
        position: relative; 
        text-align:center;
        margin-bottom: 20px;
    }

    .search-input {
        height: 50px;
        width: 50%;
        border-radius: 30px;
        padding-left: 35px;
        border: none;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .search-icon {
        position: relative;
        left: 35px;
        top: 10px;
        transform: translateY(-50%);
        color: #888;
    }

    #search-filter {
        position: relative;
        margin-left: 20px;
        height: 50px;
    }

    /* Create new order button */

    #newOrder {
        position: fixed;
    }

</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<?php if (isset($component)) { $__componentOriginalb5e767ad160784309dfcad41e788743b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb5e767ad160784309dfcad41e788743b = $attributes; } ?>
<?php $component = App\View\Components\Alert::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Alert::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb5e767ad160784309dfcad41e788743b)): ?>
<?php $attributes = $__attributesOriginalb5e767ad160784309dfcad41e788743b; ?>
<?php unset($__attributesOriginalb5e767ad160784309dfcad41e788743b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb5e767ad160784309dfcad41e788743b)): ?>
<?php $component = $__componentOriginalb5e767ad160784309dfcad41e788743b; ?>
<?php unset($__componentOriginalb5e767ad160784309dfcad41e788743b); ?>
<?php endif; ?>

<button id="newOrder">+ Créer une nouvelle commande</button>

<div id="orders">
    <div class="row justify-content-center">
        <div class="search-container">
            <i class="fas fa-search search-icon"></i>
            <input type="text" class="form-control search-input" placeholder="Search...">
            <button id="search-filter">Filtres</button>
        </div>
    </div>

    
    
    
    <table class="sortable">
    <caption>
        
        Liste des commandes à l'IUT de Villetaneuse
    </caption>
    <thead>
        <tr>
            
        <th scope="col">Numéro</th>
        <th scope="col">Département <span title="Explications, differents départements">(?)</span></th>
        <th scope="col">Désignation  <span title="Explications">(?)</span></th>
        <th scope="col">État  <span title="Explications, differents états possibles">(?)</span></th>
        <th scope="col">Date création  <span title="Explications">(?)</span></th>
        <th scope="col">Actions <span title="Les actions peuvent dépendre de votre rôle">(?)</span></th>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <th scope="row"><?php echo e($order['id']); ?></th>
                <td><strong><?php echo e($order['department']); ?></strong></br>(<?php echo e($order['author']); ?>)</td>
                <td><?php echo e($order['title']); ?></td>
                <td><span style="background-color:orange; border-radius: 30px;"><?php echo e($order['state']); ?></span></br><?php echo e($order['stateChangedAt']); ?></td>
                <td><?php echo e($order['createdAt']); ?></td>

                
                <td><strong>[Déposer un bon de commande]</strong> [Détails] [Modifier] [...]</td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
    </tbody>
    </table>
</div> 


<?php $__env->stopSection(); ?> 
<?php echo $__env->make('base', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /mnt/c/Users/Dell/Desktop/SAE301/suivi-colis-iutv/resources/views/orders.blade.php ENDPATH**/ ?>