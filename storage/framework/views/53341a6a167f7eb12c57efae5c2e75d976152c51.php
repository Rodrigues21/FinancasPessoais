

<?php $__env->startSection('content'); ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="column" style= "margin-right: 5px;  margin-bottom: 5px;">                                
            <a  href="<?php echo e(route('contas.create')); ?>" class="btn btn-success " role="button" aria-pressed="true" >Adicionar Conta</a>                                    
            </div>
            <table class="table table-striped table-bordered">
                <thead >
                    <tr>
                        <th>Nome</th>
                        <th>Saldo</th>                        
                        <th>Ações</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $contas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $conta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                                                
                        <td><?php echo e($conta->nome); ?></td>
                        <td><?php echo e($conta->saldo_atual); ?></td>
                        <td style="width:13.4%">  
                            
                            <div class="btn-group">

                                <div class="column" style= "margin-right: 5px;  margin-top: 5px;"> 
                                    <a  href="<?php echo e(route('contas.detalhes', $conta->id)); ?>" class="btn btn-primary" role="button" aria-pressed="true"><span class="fa fa-search"></span></a>
                                </div> 

                                <div class="column" style= "margin-right: 5px;  margin-top: 5px;"> 
                                    <a  href="<?php echo e(route('contas.edit', $conta)); ?>" class="btn btn-secondary" role="button" aria-pressed="true"><span class="fa fa-pencil"></span></a>
                                </div> 
                                                                
                                <div class="column" style= "margin-right: 5px;  margin-top: 5px;"> 
                                    <form action="#" method="GET">
                                        <input name="id_conta" type="hidden" value="<?php echo e($conta->id); ?>">
                                        <button type="submit" class="btn btn-danger"><span class="fa fa-trash-o"></span></a></button>                              
                                    </form> 
                                </div> 
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