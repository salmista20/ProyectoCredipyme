<template>
	<!-- The Modal -->
	<div>
		<Dialog
			class="mdlDatosCliente"
			:visible="modal_visible"
			:modal="true"
			@update:visible="Cerrar()"
			:header="'DATOS DEL CLIENTE'"
		>
			<div class="modal-body">
				<TabView>
					<TabPanel header="DATOS PRINCIPALES">
						<div class="row">
							<div class="form-group col-md-2 col-5">
								<label class="label-title">DNI</label>

								<input
									type="number"
									class="form-control center"
									:class="[
										submited
											? v$.frmDatosCliente.dni.$invalid
												? 'is-invalid'
												: 'is-valid'
											: '',
									]"
									min="0"
									step="1"
									lang="en"
									maxlength="8"
									oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
									v-model="frmDatosCliente.dni"
									:disabled="frmDatosCliente.modo == 'NO-EDITAR'"
								/>
							</div>
							<div class="form-group col-md-3 col-7">
								<label class="label-title">APELLIDO PATERNO</label>

								<textarea
									rows="1"
									class="form-control mayus"
									:class="[
										submited
											? v$.frmDatosCliente.apellido_paterno.$invalid
												? 'is-invalid'
												: 'is-valid'
											: '',
									]"
									v-model="frmDatosCliente.apellido_paterno"
									:disabled="frmDatosCliente.modo == 'NO-EDITAR'"
								></textarea>
							</div>
							<div class="form-group col-md-3 col-5">
								<label class="label-title">APELLIDO MATERNO</label>

								<textarea
									rows="1"
									class="form-control mayus"
									:class="[
										submited
											? v$.frmDatosCliente.apellido_materno.$invalid
												? 'is-invalid'
												: 'is-valid'
											: '',
									]"
									v-model="frmDatosCliente.apellido_materno"
									:disabled="frmDatosCliente.modo == 'NO-EDITAR'"
								></textarea>
							</div>
							<div class="form-group col-md-4 col-7">
								<label class="label-title">NOMBRES</label>

								<textarea
									rows="1"
									class="form-control mayus"
									:class="[
										submited
											? v$.frmDatosCliente.nombres.$invalid
												? 'is-invalid'
												: 'is-valid'
											: '',
									]"
									v-model="frmDatosCliente.nombres"
									:disabled="frmDatosCliente.modo == 'NO-EDITAR'"
								></textarea>
							</div>

							<div class="form-group col-md-4 col-6">
								<label class="label-title">FECHA DE NACIMIENTO</label>

								<input
									type="date"
									class="form-control center"
									:class="[
										submited
											? v$.frmDatosCliente.fecha_nacimiento.$invalid
												? 'is-invalid'
												: 'is-valid'
											: '',
									]"
									v-model="frmDatosCliente.fecha_nacimiento"
									:disabled="frmDatosCliente.modo == 'NO-EDITAR'"
								/>
							</div>
							<div class="form-group col-md-3 col-6">
								<label class="label-title">ESTADO CIVIL</label>

								<select
									class="form-select center"
									:class="[
										submited
											? v$.frmDatosCliente.estado_civil.$invalid
												? 'is-invalid'
												: 'is-valid'
											: '',
									]"
									v-model="frmDatosCliente.estado_civil"
									:disabled="frmDatosCliente.modo == 'NO-EDITAR'"
								>
									<option value="0" disabled>Seleccione...</option>
									<option value="Soltero">Soltero</option>
									<option value="Casado">Casado</option>
									<option value="Conviviente">Conviviente</option>
									<option value="Divorciado">Divorciado</option>
									<option value="Viudo">Viudo</option>
								</select>
							</div>
							<div class="form-group col-md-3 col-6">
								<label class="label-title">GÉNERO</label>

								<select
									class="form-control center"
									:class="[
										submited
											? v$.frmDatosCliente.sexo.$invalid
												? 'is-invalid'
												: 'is-valid'
											: '',
									]"
									v-model="frmDatosCliente.sexo"
									:disabled="frmDatosCliente.modo == 'NO-EDITAR'"
								>
									<option value="0" disabled>Seleccione...</option>
									<option value="F">Femenino</option>
									<option value="M">Masculino</option>
								</select>
							</div>

							<div class="form-group col-md-8 col-12">
								<label class="label-title">EMAIL</label>
								<form autocomplete="off">
									<input
										type="text"
										class="form-control"
										v-model="frmDatosCliente.email"
										:disabled="
											frmDatosCliente.modo == 'NO-EDITAR' ||
											frmDatosCliente.modo == 'PARIENTE_AVAL'
										"
									/>
								</form>
							</div>

							<div class="form-group col-md-4 col-6">
								<label class="label-title">EXPEDIENTE</label>

								<input
									type="text"
									class="form-control center"
									:value="
										frmDatosCliente.codigo_expediente == null
											? '-'
											: frmDatosCliente.codigo_expediente
									"
									:disabled="true"
								/>
							</div>
							<div class="form-group col-md-4 col-6">
								<label class="label-title">ASESOR</label>

								<select
									class="form-control center"
									:class="[
										submited
											? v$.frmDatosCliente.asesor_id.$invalid
												? 'is-invalid'
												: 'is-valid'
											: '',
									]"
									v-model="frmDatosCliente.asesor_id"
									:disabled="
										frmDatosCliente.modo == 'NO-EDITAR' ||
										frmDatosCliente.modo != 'NUEVO'
									"
								>
									<option value="0" disabled>Seleccione...</option>
									<option
										v-for="(asesor, index) in lista_asesores"
										:key="index"
										:value="asesor.dni"
										selected
									>
										{{
											asesor.usuario +
											" - " +
											asesor.nombres +
											" " +
											asesor.apellido_paterno
										}}
									</option>
								</select>
							</div>
							<div class="form-group col-md-12 col-12">
								<label class="label-title"> NOTAS </label>

								<textarea
									class="form-control mayus text-row"
									rows="2"
									v-model="frmDatosCliente.notas"
									:disabled="frmDatosCliente.modo == 'NO-EDITAR'"
								></textarea>
							</div></div
					></TabPanel>
					<TabPanel header="DIRECCIÓN Y TELÉFONOS">
						<div class="form-row">
							<div class="form-group col-md-12">
								<label class="label-title">DIRECCIÓN</label>
								<textarea
									class="form-control mayus"
									:class="[
										submited
											? v$.frmDatosCliente.direccion.$invalid
												? 'is-invalid'
												: 'is-valid'
											: '',
									]"
									rows="1"
									v-model="frmDatosCliente.direccion"
									:disabled="frmDatosCliente.modo == 'NO-EDITAR'"
								></textarea>
							</div>
							<div class="form-group col-md-4 col-4">
								<label class="label-title">DEPARTAMENTO</label>
								<select
									class="form-control center"
									:class="[
										submited
											? v$.frmDatosCliente.departamento_id.$invalid
												? 'is-invalid'
												: 'is-valid'
											: '',
									]"
									@change="FiltrarProvincias"
									v-model="frmDatosCliente.departamento_id"
									:disabled="frmDatosCliente.modo == 'NO-EDITAR'"
								>
									<option value="0" disabled>Seleccione...</option>
									<option
										v-for="departamento in departamentos"
										:key="departamento.id"
										:value="departamento.id"
									>
										{{ departamento.departamento }}
									</option>
								</select>
							</div>
							<div class="form-group col-md-4 col-4">
								<label class="label-title">PROVINCIA</label>

								<select
									class="form-control center"
									:class="[
										submited
											? v$.frmDatosCliente.provincia_id.$invalid
												? 'is-invalid'
												: 'is-valid'
											: '',
									]"
									@change="FiltrarDistritos"
									v-model="frmDatosCliente.provincia_id"
									:disabled="frmDatosCliente.modo == 'NO-EDITAR'"
								>
									<option value="0" disabled>Seleccione...</option>
									<option
										v-for="provincia in provincias_filtradas"
										:key="provincia.id"
										:value="provincia.id"
									>
										{{ provincia.provincia }}
									</option>
								</select>
							</div>
							<div class="form-group col-md-4 col-4">
								<label class="label-title">DISTRITO</label>

								<select
									class="form-control center"
									:class="[
										submited
											? v$.frmDatosCliente.distrito_id.$invalid
												? 'is-invalid'
												: 'is-valid'
											: '',
									]"
									v-model="frmDatosCliente.distrito_id"
									:disabled="frmDatosCliente.modo == 'NO-EDITAR'"
								>
									<option value="0" disabled>Seleccione...</option>
									<option
										v-for="distrito in distritos_filtrados"
										:key="distrito.id"
										:value="distrito.id"
									>
										{{ distrito.distrito }}
									</option>
								</select>
							</div>

							<div class="form-group col-md-12 col-12">
								<label class="label-title">REFERENCIA</label>

								<form autocomplete="off">
									<textarea
										class="form-control text-row mayus"
										:class="[
											submited
												? v$.frmDatosCliente.referencia_direccion.$invalid
													? 'is-invalid'
													: 'is-valid'
												: '',
										]"
										rows="3"
										v-model="frmDatosCliente.referencia_direccion"
										:disabled="frmDatosCliente.modo == 'NO-EDITAR'"
									/>
								</form>
							</div>

							<div class="form-group col-md-4 col-4">
								<label class="label-title">NÚMERO</label>

								<div class="input-group">
									<div class="input-group-prepend" v-if="windowWidth > 1000">
										<span class="input-group-text">1</span>
									</div>

									<input
										type="number"
										min="0"
										lang="en"
										class="form-control center"
										:class="[
											submited
												? v$.frmDatosCliente.telefonos.t1.$invalid
													? 'is-invalid'
													: 'is-valid'
												: '',
										]"
										maxlength="9"
										oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
										v-model="frmDatosCliente.telefonos.t1"
										:disabled="frmDatosCliente.modo == 'NO-EDITAR'"
									/>
								</div>
							</div>

							<div class="form-group col-md-4 col-4">
								<label class="label-title">OPERADOR</label>

								<div class="input-group">
									<div class="input-group-prepend" v-if="windowWidth > 1000">
										<span class="input-group-text">1</span>
									</div>

									<select
										class="form-control center"
										v-model="frmDatosCliente.telefonos.o1"
										:class="[
											submited
												? v$.frmDatosCliente.telefonos.o1.$invalid
													? 'is-invalid'
													: 'is-valid'
												: '',
										]"
										:disabled="frmDatosCliente.modo == 'NO-EDITAR'"
									>
										<option :value="0" disabled>Seleccione...</option>
										<option value="Movistar">Movistar</option>
										<option value="Claro">Claro</option>
										<option value="Bitel">Bitel</option>
										<option value="Entel">Entel</option>
									</select>
								</div>
							</div>

							<div class="form-group col-md-4 col-4">
								<label class="label-title">NOTAS</label>

								<div class="input-group">
									<div class="input-group-prepend" v-if="windowWidth > 1000">
										<span class="input-group-text">1</span>
									</div>

									<textarea
										rows="1"
										class="form-control mayus"
										:class="[
											submited
												? v$.frmDatosCliente.telefonos.n1.$invalid
													? 'is-invalid'
													: 'is-valid'
												: '',
										]"
										v-model="frmDatosCliente.telefonos.n1"
										:disabled="frmDatosCliente.modo == 'NO-EDITAR'"
									></textarea>
								</div>
							</div>

							<div class="form-group col-md-4 col-4">
								<div class="input-group">
									<div class="input-group-prepend" v-if="windowWidth > 1000">
										<span class="input-group-text">2</span>
									</div>
									<input
										type="number"
										min="0"
										lang="en"
										class="form-control center"
										style="max-width: 400px"
										maxlength="9"
										oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
										v-model="frmDatosCliente.telefonos.t2"
										:disabled="frmDatosCliente.modo == 'NO-EDITAR'"
									/>
								</div>
							</div>
							<div class="form-group col-md-4 col-4">
								<div class="input-group">
									<div class="input-group-prepend" v-if="windowWidth > 1000">
										<span class="input-group-text">2</span>
									</div>
									<select
										class="form-control center"
										v-model="frmDatosCliente.telefonos.o2"
										:disabled="frmDatosCliente.modo == 'NO-EDITAR'"
									>
										<option value="0" disabled>Seleccione...</option>
										<option value="Movistar">Movistar</option>
										<option value="Claro">Claro</option>
										<option value="Bitel">Bitel</option>
										<option value="Entel">Entel</option>
									</select>
								</div>
							</div>

							<div class="form-group col-md-4 col-4">
								<div class="input-group">
									<div class="input-group-prepend" v-if="windowWidth > 1000">
										<span class="input-group-text">2</span>
									</div>

									<textarea
										rows="1"
										class="form-control mayus"
										style="max-width: 500px"
										v-model="frmDatosCliente.telefonos.n2"
										:disabled="frmDatosCliente.modo == 'NO-EDITAR'"
									></textarea>
								</div>
							</div>

							<div class="form-group col-md-4 col-4">
								<div class="input-group">
									<div class="input-group-prepend" v-if="windowWidth > 1000">
										<span class="input-group-text">3</span>
									</div>
									<input
										type="number"
										min="0"
										lang="en"
										class="form-control center"
										style="max-width: 400px"
										maxlength="9"
										oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
										v-model="frmDatosCliente.telefonos.t3"
										:disabled="frmDatosCliente.modo == 'NO-EDITAR'"
									/>
								</div>
							</div>
							<div class="form-group col-md-4 col-4">
								<div class="input-group">
									<div class="input-group-prepend" v-if="windowWidth > 1000">
										<span class="input-group-text">3</span>
									</div>
									<select
										class="form-control center"
										v-model="frmDatosCliente.telefonos.o3"
										:disabled="frmDatosCliente.modo == 'NO-EDITAR'"
									>
										<option value="0" disabled>Seleccione...</option>
										<option value="Movistar">Movistar</option>
										<option value="Claro">Claro</option>
										<option value="Bitel">Bitel</option>
										<option value="Entel">Entel</option>
									</select>
								</div>
							</div>
							<div class="form-group col-md-4 col-4">
								<div class="input-group">
									<div class="input-group-prepend" v-if="windowWidth > 1000">
										<span class="input-group-text">3</span>
									</div>
									<textarea
										rows="1"
										class="form-control mayus"
										style="max-width: 500px"
										v-model="frmDatosCliente.telefonos.n3"
										:disabled="frmDatosCliente.modo == 'NO-EDITAR'"
									></textarea>
								</div>
							</div>

							<!-- ----- -->
						</div>
					</TabPanel>
					<TabPanel header="DNI">
						<div class="smartcenter form-row justify-content-md-center">
							<div class="smartcenter form-group justify-content-md-center">
								<div
									class="mt-3 mb-1"
									id="previzualizar"
									style="border: 1px solid #ffff; width: 600px; height: 300px"
								></div>
							</div>
						</div>

						<!-- ----**** ---- -->
						<div class="text-center mb-3">
							<button
								class="btn btn-cancel btn-icon-split"
								@click="Descargar"
								v-if="
									frmDatosCliente.modo == 'NO-EDITAR' &&
									frmDatosCliente.imagen_dni != null
								"
							>
								<span class="icon text-white">
									<i class="fas fa-download"></i>
								</span>
								<span class="text font-size-layout">Descargar</span>
							</button>
						</div>
						<!-- ---*********---- -->

						<div class="form-row">
							<div class="form-group col-md-6">
								<label class="label-title" id="lblfotoDNI">FOTO DE DNI</label>
								<input
									class="btn btn-primary"
									style="
										background-color: var(--plomoOscuroEmpresarial);
										border: none;
										max-width: 400px;
										font-size: 12px;
									"
									type="file"
									accept="image/*"
									name="fotoDNI"
									id="inpFoto"
									@change="AgregarDNI"
									:disabled="frmDatosCliente.modo == 'NO-EDITAR'"
								/>
							</div></div
					></TabPanel>
				</TabView>
				<hr />

				<div class="text-right">
					<div class="btn-group" role="group">
						<button
							class="btn btn-action btn-icon-split"
							@click="Habilitar_editar"
							v-if="frmDatosCliente.modo == 'NO-EDITAR'"
						>
							<span class="icon text-white">
								<i class="fas fa-edit"></i>
							</span>
							<span class="text">EDITAR</span>
						</button>
						<button
							class="btn btn-action btn-icon-split"
							@click="GuardarCliente"
							v-if="
								frmDatosCliente.modo == 'EDITAR' ||
								frmDatosCliente.modo == 'NUEVO'
							"
						>
							<span class="icon text-white">
								<i class="fas fa-save"></i>
							</span>
							<span class="text">GUARDAR</span>
						</button>
					</div>
				</div>
			</div>
		</Dialog>
	</div>
</template>

<script>
import Dialog from "primevue/dialog";
import TabView from "primevue/tabview";
import TabPanel from "primevue/tabpanel";

const api_url = import.meta.env.VITE_API_URL;
export default {
	props: { agencias: Array },
	components: {
		Dialog,
		TabView,
		TabPanel,
	},
	data() {
		return {
			windowWidth: window.innerWidth,
			submited: false,
			modal_visible: false,

			lista_asesores: [],
			departamentos: [],
			provincias: [],
			provincias_filtradas: [],
			distritos: [],
			distritos_filtrados: [],

			frmDatosCliente: {
				modo: null,
				id: null,
				dni: null,
				apellido_paterno: null,
				apellido_materno: null,
				nombres: null,
				fecha_nacimiento: null,
				estado_civil: null,
				genero: null,
				email: null,
				expediente: null,
				asesor_id: null,
				agencia_id: null,
				direccion: null,
				departamento_id: null,
				provincia_id: null,
				distrito_id: null,
				referencia_direccion: null,
				telefonos: {
					t1: null,
					t2: null,
					t3: null,
					o1: null,
					o2: null,
					o3: null,
					n1: null,
					n2: null,
					n3: null,
				},
				imagen_dni: null,
				notas: null,
			},
		};
	},
	mounted() {
		window.addEventListener("resize", () => {
			this.windowWidth = window.innerWidth;
		});
	},
	methods: {
		async ListarRecursos() {
			let self = this;
			return await axios
				.get(api_url + "/cli/gestion/listar_recursos/")
				.then(function (response) {
					self.departamentos = response.data.departamentos;
					self.provincias = response.data.provincias;
					self.distritos = response.data.distritos;
				});
		},
		Cerrar() {
			this.modal_visible = false;
		},
	},
};
</script>

<style lang="scss">
.mdlDatosCliente {
	width: 50%;
}

@media (max-width: 992px) {
	.mdlDatosCliente {
		width: 80%;
	}
}

@media (max-width: 400px) {
	.mdlDatosCliente {
		width: 80%;
	}
}
</style>
