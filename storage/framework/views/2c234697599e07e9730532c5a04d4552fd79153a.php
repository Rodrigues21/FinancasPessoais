<?php $__env->startSection('content'); ?>
<div class="col-lg-12 text-center">
    <h1 class="mt-5">Bem Vindo!</h1>
    <p class="lead">A Finanças Pessoais é uma aplicação web que permite aos seus <?php echo e($users); ?> utilizadores gerir as suas finanças pessoais!</p>
    <p class="lead">Os Utilizadores possuem atualmente <?php echo e($contas); ?> contas e efetuaram um total de <?php echo e($movimentos); ?> movimentos!</p>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\ainet\FinancasPessoais\resources\views/home.blade.php ENDPATH**/ ?>