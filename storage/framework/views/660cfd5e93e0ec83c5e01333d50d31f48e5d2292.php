

<?php $__env->startSection('content'); ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            
            <p><form action="<?php echo e(route('perfis')); ?>" method="GET">
                 <div class="input-group">
                    
                    <input name="name" placeholder="Nome" value="<?php echo e(request()->input('name')); ?>">
                    <input name="email" placeholder="Email" value="<?php echo e(request()->input('email')); ?>">
                    <?php if($user->adm): ?>
                        <select class="custom-select" name="estado" id="estado">
                            <option value="empty">Escolher Bloqueado Ou Desbloqueado</option>
                            <option value="1" <?php echo e(request()->input('estado') === '1' ? 'selected' : ''); ?>>Bloqueado</option>
                            <option value="0" <?php echo e(request()->input('estado') === '0' ? 'selected' : ''); ?>>Desbloqueado</option>
                        </select>
                        <select class="custom-select" name="tipo" id="tipo" placeholder="Tipo">
                            <option value="empty">Escolher Administrador Ou Utilizador</option>
                            <option value="1">Administrador</option>
                            <option value="0">Utilizador</option>                	
                        </select>
                    <?php endif; ?>
                
                            
        
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">Filtrar</button>
                </div> 
                </div> 
            </form></p>

            
            
            
            <table class="table table-striped table-bordered">
                <thead >
                    <tr>
                        <th>Foto</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <?php if($user->adm): ?>
                            <th>Tipo</th>
                            <th>Estado</th>
                            <th>Ações</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td>
                        <?php if($u->foto): ?>
                            <img src="<?php echo e(asset('storage/fotos/'.$u->foto)); ?>"  width="100"  style="max-width: 100%;  object-fit: cover"></td>
                        <?php else: ?>
                            <img src="storage/fotos/foto.png"  width="100" style="max-width: 100%; object-fit: cover">                        
                        <?php endif; ?>
                        <td><?php echo e($u->name); ?></td>
                        <td><?php echo e($u->email); ?></td>
                        <?php if($user->adm): ?>
                            <td><?php echo e($u->adm ? 'Administrador' : 'Utilizador'); ?></th>
                            <td><?php echo e($u->bloqueado ? 'Bloqueado' : 'Desbloqueado'); ?></th>
                            <td style="width:10%">                                
                                

                                    <?php if($user->id != $u->id): ?>
                                    <div class="btn-group">
                                        <div class="column" style= "margin-right: 5px;  margin-top: 5px;"> 
                                            <form action="<?php echo e(route('perfis.promote')); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <input name="block_promote" type="hidden" value="<?php echo e($u->id); ?>">
                                                <?php if($u->adm): ?>
                                                    <button type="submit" class="btn btn-danger "><span class="fa fa-arrow-down"></span></button>
                                                <?php else: ?>
                                                    <button type="submit" class="btn btn-success"><span class="fa fa-arrow-up"></span></button>
                                                <?php endif; ?>
                                                
                                            </form> 
                                        </div>

                                        <div class="column" style= "margin-right: 5px;  margin-top: 5px;">  
                                            <form action="<?php echo e(route('perfis.block')); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <input name="block_user" type="hidden" value="<?php echo e($u->id); ?>">
                                                <?php if($u->bloqueado): ?>
                                                    <button type="submit" class="btn btn-success"><span class="fa fa-unlock"></span></button>
                                                <?php else: ?>
                                                    <button type="submit" class="btn btn-danger"><span class="fa fa-lock"></span></button>
                                                <?php endif; ?>
                                                
                                            </form> 
                                        </div>
                                   
                                
                               
                                        
                                </div>
                                    <?php endif; ?> 
                               
                                    
                                    
                                
                            </td>
                        <?php endif; ?>
                    
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <?php echo e($users->withQueryString()->links()); ?>


</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\ainet\FinancasPessoais\resources\views/users/perfil.blade.php ENDPATH**/ ?>