

<?php $__env->startSection('content'); ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
        <h1><?php echo e($conta->nome); ?></h1>
        <p><?php echo e($conta->descricao); ?></p>
        <p>Saldo Abertura: <?php echo e($conta->saldo_abertura); ?>€</p>
        <p>Saldo Atual: <?php echo e($conta->saldo_atual); ?>€</p>
            <div class="column" style= "margin-right: 5px;  margin-bottom: 5px;">                                
            <a  href="<?php echo e(route('movimento.create', $conta->id)); ?>" class="btn btn-success " title="Adicionar Movimento" role="button" aria-pressed="true" ><span class="fa fa-plus"></a>                                    
            </div>
            <p><form action="<?php echo e(route('contas.detalhes', $conta->id)); ?>" method="GET">
                <div class="input-group">
                   
                   
                   <input type="date" name="data" class="form-control" id="data" placeholder="Data" value="<?php echo e(request()->input('data')); ?>">
                   <select name="tipo" id="inputType" class="form-control">
                        <option value="empty"> Escolha uma Opção </option>
                        <option value="D"  <?php echo e(request()->input('tipo') === 'D' ? 'selected' : ''); ?>>Despesa</option>
                        <option value="R"  <?php echo e(request()->input('tipo') === 'R' ? 'selected' : ''); ?>>Receita</option>
                    </select>

                    <select name="categoria_id" id="inputType" class="form-control">
                        <option  value="empty"> Escolha uma Opção </option>
                        <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>:
                            <option value="<?php echo e($categoria->id); ?>" <?php echo e(request()->input('categoria_id') === $categoria->id ? 'selected' : ''); ?>><?php echo e($categoria->nome); ?></option>
 
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                  
               
                           
       
                   <div class="input-group-append">
                       <button class="btn btn-outline-secondary" type="submit">Filtrar</button>
                   </div> 
               </div> 
           </form></p>
            <table class="table table-striped table-bordered">
                <thead >
                    <tr>
                        <th>Data</th>
                        <th>Valor</th>                        
                        <th>Saldo Inicial</th>
                        <th>Saldo Final</th>
                        <th>Categoria</th>
                        <th>Tipo</th>
                        <th>Ações</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $movimentos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mov): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                                                    
                        <td><?php echo e($mov->data); ?></td>
                            <td><?php echo e($mov->valor); ?></td>
                            <td><?php echo e($mov->saldo_inicial); ?></td>
                            <td><?php echo e($mov->saldo_final); ?></td>
                            <td><?php echo e($mov->categoria->nome ?? ''); ?></td>
                            <td><?php echo e($mov->tipo == 'D' ? 'Despesa' : 'Receita'); ?></td>
                            <td style="width:13.4%">  
                                <div class="btn-group" >            

                                    <div class="column" style= "margin-right: 5px;  margin-top: 5px;">                                
                                        <a  href="<?php echo e(route('movimento.edit', $mov)); ?>" title="Editar Movimento" class="btn btn-secondary" role="button" aria-pressed="true" ><span class="fa fa-pencil"></a>                                    
                                    </div>
    
                                    <div class="column" style= "margin-right: 5px;  margin-top: 5px;"> 
                                        <form action="<?php echo e(route('movimento.destroy', $mov)); ?>" method="POST">

                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('delete'); ?>

                                            <button type="submit" title="Apagar Movimento" class="btn btn-danger"><span class="fa fa-trash-o"></span></a></button>                              
                                        </form> 
                                    </div> 

                                    <?php if($mov->descricao != null || $mov->imagem_doc != null): ?>
                                        <div class="column" style= "margin-right: 5px;  margin-top: 5px;">                                     
                                        <button type="button" title="Detalhes do Movimento"class="btn btn-primary" data-toggle="modal" data-target="#exampleModal-<?php echo e($mov->id); ?>">
                                            <span class="fa fa-search"></span>
                                        </button>
                                        </div>
                                    <?php endif; ?>

                                    <div class="modal fade" id="exampleModal-<?php echo e($mov->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <h5 class="modal-title" id="exampleModalLabel">Detalhes do Movimento</h5>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                              </button>
                                            </div>
                                            <div class="modal-body">
                                                <p><?php echo e($mov->descricao); ?></p>

                                                <?php if( isset($mov->imagem_doc) ): ?>                            
                                                    <img src="<?php echo e(route('movimentos.doc',$mov->id)); ?>">
                                                <?php endif; ?>
                                            </div>
                                            
                                          </div>
                                        </div>
                                      </div>
                                </div>    
                            </td>
                        
                        
                        </tr>
                        

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <?php echo e($movimentos->withQueryString()->links()); ?>


</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\ainet\FinancasPessoais\resources\views/contas/detalhe.blade.php ENDPATH**/ ?>