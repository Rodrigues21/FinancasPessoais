

<?php $__env->startSection('content'); ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="column" style= "margin-right: 5px;  margin-bottom: 5px;">                                
            <a  href="<?php echo e(route('contas.create')); ?>" class="btn btn-success " title="Adicionar Conta" role="button" aria-pressed="true" ><span class="fa fa-plus"></a>
            <?php if(!request()->apagadas): ?>
                <a  href="<?php echo e(route('contas')); ?>?apagadas=1" class="btn btn-info " title="Mostrar Contas Eliminadas" role="button" aria-pressed="true" ><span class="fa fa-eye"></a>
            <?php else: ?>
                <a  href="<?php echo e(route('contas')); ?>" class="btn btn-info" role="button" title="Esconder Contas Eliminadas" aria-pressed="true" ><span class="fa fa-eye-slash"></a>
            <?php endif; ?>
            </div>
            <table class="table table-striped table-bordered">
                <thead >
                    <tr>
                        <th>Nome</th>
                        <th>Saldo</th>   
                        <th>Estado</th>                     
                        <th>Ações</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $contas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $conta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                                                
                        <td><?php echo e($conta->nome); ?></td>
                        <td><?php echo e($conta->saldo_atual); ?></td>
                        <td><?php echo e($conta->deleted_at == null ? 'Ativa' : 'Apagada'); ?></td>
                        <td style="width:19%">  
                            
                            <div class="btn-group">

                                <div class="column" style= "margin-right: 5px;  margin-top: 5px;"> 
                                    <a  href="<?php echo e(route('contas.detalhes', $conta->id)); ?>" title="Detalhes Conta" class="btn btn-primary" role="button" aria-pressed="true"><span class="fa fa-search"></span></a>
                                </div> 

                                <div class="column" style= "margin-right: 5px;  margin-top: 5px;"> 
                                    <a  href="<?php echo e(route('contas.edit', $conta)); ?>" title="Editar Conta" class="btn btn-secondary" role="button" aria-pressed="true"><span class="fa fa-pencil"></span></a>
                                </div> 
                                                                
                                <span class="column" style= "margin-right: 5px;  margin-top: 5px;"> 
                                    <?php if($conta->deleted_at == null): ?>
                                        <form class="form-inline" action="<?php echo e(route('contas.delete', $conta->id)); ?>" method="GET">
                                            <button type="submit" title="Apagar Conta" class="btn btn-danger"><span class="fa fa-trash-o"></span></a></button>                              
                                        </form>
                                    <?php else: ?>
                                        <form class="form-inline pull-left" action="<?php echo e(route('contas.activate', $conta->id)); ?>" method="GET">
                                            <button type="submit" title="Ativar Conta" style= "margin-right: 5px;" class="btn btn-success"><span class="fa fa-check"></span></a></button>                              
                                        </form>
                                        <form class="form-inline pull-left" action="<?php echo e(route('contas.forcedelete', $conta->id)); ?>" method="GET">
                                            <button type="submit" title="Eliminar Permanentemente Conta" class="btn btn-danger"><span class="fa fa-ban"></span></a></button>                              
                                        </form>
                                    <?php endif; ?> 
                                </span> 
                            </div>    
                        </td>
                       
                    
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <?php echo e($contas->withQueryString()->links()); ?>


</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\ainet\FinancasPessoais\resources\views/contas/index.blade.php ENDPATH**/ ?>