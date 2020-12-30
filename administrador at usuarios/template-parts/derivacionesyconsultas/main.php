<?php 
/*
**
*   Tabla de derivaciones y consultas
*
*/
?>
    <div class="row searcher">
        <div class="col">
                <form method='POST' id='formcarga' name='formcarga'>
                    
                        <div class="row rowadapt" style='margin-bottom:15px;     border-right: 1px solid lightgrey;'>
                            <div class="col">
                                <h5 style='margin-bottom: 15px;'>Cargar nueva</h5>
                                <label>Tipo</label><br>
                                    <select name="tipo" id="tipo" class='selectcyd'>
                                        <option value="CONSULTA">CONSULTA</option>
                                        <option value="DERIVACION">DERIVACION</option>
                                        <option value="OTRO">OTRO</option>
                                    </select><br>
                                <label>Derivado a (solo en derivacion)</label><br>
                                    <select name="derivado" id="derivado" class='selectcyd'>
                                        <option value="">--Elegir una--</option>
                                        <option value="Municipalidad de lanus">Municipalidad de Lanus</option>
                                        <option value="Municipalidad de Vicente Lopez">Municipalidad de Vicente Lopez</option>
                                    </select><br>
                            </div>
                            <div class="col">
                                <label>Observacion</label><br>
                                <textarea name="obs" id="obs" cols="20" rows="5" class='textareacyd'></textarea><br>
                                <button type='submit' class='buttonssearch' style='width:250px!important; background-color:grey;'>Cargar</button>
                            </div>
                        </div>
                </form>
        </div>
        <div class="col">
                <form method='POST' id='searchderivycons'>
                <h5 style='margin-bottom: 15px; margin-left:25px;'>BUSQUEDA</h5>
                    <div class="row rowadapt">
                    
                        <div class="col">
                            <label>Fecha desde:</label><br>
                            <input type="date" name='fechadesdedyc' class='inputcyd' id='fechadesdedyc' ><br>
                            <label>Tipo</label><br>
                            <select name="tipodyc" class='selectcyd' id="tipodyc">
                            <option value="true">TODOS</option>
                            <option value="CONSULTA">CONSULTA</option>
                            <option value="DERIVACION">DERIVACION</option>
                            <option value="OTROS">OTROS</option>
                        </select><br>
                        </div>
                        <div class="col">
                            <label>Fecha hasta:</label><br>
                            <input type="date" name='fechahastadyc' id='fechahastadyc' class='inputcyd' ><br>
                            <button type='submit' class='buttonssearch'  style='width:250px!important; background-color:grey; margin-top: 20px;'>Buscar</button>
                        </div>
                    </div>
            
                </form>
        </div>
    </div>
                            <table class="table table-sm" id='tablelist'>
										<thead>
											<tr>
												<th>
													ID
												</th>
												<th>
													Tipo
												</th>
												<th>
													Derivacion
												</th>
												<th>
													Observacion
												</th>
                                                <th>
													Fecha
												</th>
                                                <th>
                                                    Borrar
                                                </th>
											</tr>
										</thead>
										<tbody id='tbodylist'>
                                            <?php 
                                            /*
                                            *
                                            *   Body table - jquery - /DerivyCons.js
                                            *
                                            */
                                            ?>
										</tbody>
	                        </table>


                            