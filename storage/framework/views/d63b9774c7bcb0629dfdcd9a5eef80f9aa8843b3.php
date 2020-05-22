

<?php $__env->startSection('content'); ?>

<div class="col-lg-12 text-center">
    <div>
        <?php if($user->foto): ?>
            <img src="<?php echo e(asset('storage/fotos/'.$user->foto)); ?>"  width="170" height="170" style="max-width: 100%;  border-radius: 50%; object-fit: cover">                        
        <?php else: ?>
            <img src="storage/fotos/foto.png" class="rounded" width="170" height="170" style="max-width: 100%; border-radius: 50%; object-fit: cover">                        
        <?php endif; ?>
    </div>
    
        <div>  
            <h1><?php echo e($user->name); ?></h1>
        </div>
        <div class="column"> 
        <div>
            <p><span class="fa fa-envelope-o" style= "margin-right: 5px"></span><?php echo e($user->email); ?></p>
        </div>

        <div>
            <?php if($user->NIF): ?>
                <p><span class="fa fa-id-card" style= "margin-right: 5px"></span><?php echo e($user->NIF); ?></p>               
            <?php endif; ?>
        </div>
        <div>
            <?php if($user->telefone): ?>
                <p><span class="fa fa-phone" style= "margin-right: 5px"></span><?php echo e($user->telefone); ?></p>
            <?php endif; ?>
        </div>
    </div>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="d-flex flex-row" >
            <div class="column" style= "margin-right: 5px; margin-top: 5px;" >
                <a  href="<?php echo e(route('me.edit')); ?>" class="btn btn-primary" role="button" aria-pressed="true">Editar Perfil</a>                              
            </div>

            <div class="column" style= "margin-right: 5px;  margin-top: 5px;">                                
                <a  href="<?php echo e(route('me.edit.password')); ?>" class="btn btn-primary" role="button" aria-pressed="true" >Alterar Password</a>                                    
            </div>

            <div class="column" style= "margin-right: 5px;  margin-top: 5px;">                                
                <a  href="#" class="btn btn-danger" role="button" aria-pressed="true" >Apagar Conta</a>                                    
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\ainet\FinancasPessoais\resources\views/user/index.blade.php ENDPATH**/ ?>