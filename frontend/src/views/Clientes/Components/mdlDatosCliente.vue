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
							<div class="form-group col-md-3 col-6">
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
							<div class="form-group col-md-4 col-6">
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
									<option value="SOLTERO">SOLTERO</option>
									<option value="CASADO">CASADO</option>
									<option value="CONVIVIENTE">CONVIVIENTE</option>
									<option value="DIVORCIADO">DIVORCIADO</option>
									<option value="VIUDO">VIUDO</option>
								</select>
							</div>
							<div class="form-group col-md-3 col-6">
								<label class="label-title">GÉNERO</label>

								<select
									class="form-select center"
									:class="[
										submited
											? v$.frmDatosCliente.genero.$invalid
												? 'is-invalid'
												: 'is-valid'
											: '',
									]"
									v-model="frmDatosCliente.genero"
									:disabled="frmDatosCliente.modo == 'NO-EDITAR'"
								>
									<option :value="0" disabled>Seleccione...</option>
									<option value="F">FEMENINO</option>
									<option value="M">MASCULINO</option>
									<option value="O">OTROS</option>
								</select>
							</div>
							<div class="form-group col-md-3 col-6">
								<label class="label-title">AGENCIA</label>

								<select
									class="form-select center"
									:class="[
										submited
											? v$.frmDatosCliente.agencia_id.$invalid
												? 'is-invalid'
												: 'is-valid'
											: '',
									]"
									v-model="frmDatosCliente.agencia_id"
									@change="FiltrarAsesores"
									:disabled="frmDatosCliente.modo == 'NO-EDITAR'"
								>
									<option
										v-for="(item, index) in agencias"
										:key="index"
										:value="item.id"
									>
										{{ item.agencia }}
									</option>
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
									class="form-select center"
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
									<option :value="0" disabled>Seleccione...</option>
									<option
										v-for="(item, index) in asesores_filtrados"
										:key="index"
										:value="item.id"
										selected
									>
										{{ item.usuario }}
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
						<div class="row">
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
									class="form-select center"
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
									<option :value="0" disabled>Seleccione...</option>
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
									class="form-select center"
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
									<option :value="0" disabled>Seleccione...</option>
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
									class="form-select center"
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
									<option :value="0" disabled>Seleccione...</option>
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
										class="form-select center"
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
										<option v-for="(item, index) in operadores" :key="index">
											{{ item }}
										</option>
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
										class="form-select center"
										v-model="frmDatosCliente.telefonos.o2"
										:disabled="frmDatosCliente.modo == 'NO-EDITAR'"
									>
										<option :value="0" disabled>Seleccione...</option>
										<option v-for="(item, index) in operadores" :key="index">
											{{ item }}
										</option>
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
										class="form-select center"
										v-model="frmDatosCliente.telefonos.o3"
										:disabled="frmDatosCliente.modo == 'NO-EDITAR'"
									>
										<option :value="0" disabled>Seleccione...</option>
										<option v-for="(item, index) in operadores" :key="index">
											{{ item }}
										</option>
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
						<!-- <div class="smartcenter form-row justify-content-md-center">
							<div class="smartcenter form-group justify-content-md-center">
								<div
									class="mt-3 mb-1"
									id="previzualizar"
									style="border: 1px solid #ffff; width: 600px; height: 300px"
								></div>
							</div>
						</div>

				
						<div class="text-center mb-3">
							<button
								class="btn btn-main-1 btn-icon-split"
								@click="Descargar"
								v-if="
									frmDatosCliente.modo == 'NO-EDITAR' &&
									frmDatosCliente.imagen_dni != null
								"
							>
								<span class="icon text-white">
									<i class="pi pi-download"></i>
								</span>
								<span class="text font-size-layout">Descargar</span>
							</button>
						</div>
					

						<div class="form-row">
							<div class="form-group col-md-6">
								<label class="label-title" id="lblfotoDNI">FOTO DE DNI</label>
								<input
									class="btn btn-main-2"
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
					> -->
						<div class="form-row">
							<div
								class="form-group foto-container col-md-6 col-12"
								id="contenido"
							>
								<label
									for="foto"
									class="subir"
									v-if="frmDatosCliente.imagen_dni == null"
								>
									<i
										class="pi pi-plus-circle foto-icon"
										style="font-size: 100px"
									></i>
								</label>
								<input
									id="foto"
									type="file"
									accept="image/*"
									style="display: none"
									@change="AgregarFoto"
									v-if="frmDatosCliente.imagen_dni == null"
								/>

								<img class="d-block w-100" id="img" />
								<button
									class="btn btn-danger delete"
									title="Quitar FOTO"
									@click="QuitarFoto('foto')"
									v-if="frmDatosCliente.imagen_dni != null"
								>
									<span class="icon text-white">
										<i class="pi pi-trash"></i>
									</span>
								</button>
							</div>
						</div>
					</TabPanel>
				</TabView>
				<hr />

				<div class="text-right">
					<div class="btn-group" role="group">
						<button
							class="btn btn-main-1 btn-icon-split"
							@click="Habilitar_editar"
							v-if="frmDatosCliente.modo == 'NO-EDITAR'"
						>
							<span class="icon text-white">
								<i class="pi pi-edit"></i>
							</span>
							<span class="text">EDITAR</span>
						</button>
						<button
							class="btn btn-main-1 btn-icon-split"
							@click="GuardarCliente"
							v-if="
								frmDatosCliente.modo == 'EDITAR' ||
								frmDatosCliente.modo == 'NUEVO'
							"
						>
							<span class="icon text-white">
								<i class="pi pi-save"></i>
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

import FileUpload from "primevue/fileupload";
import ImagePreview from "primevue/image";

const api_url = import.meta.env.VITE_API_URL;
const image_url = import.meta.env.VITE_IMAGE_URL;
export default {
	props: { agencias: Array, datos_sesion: Object },
	components: {
		Dialog,
		TabView,
		TabPanel,

		FileUpload,
		ImagePreview,
	},
	data() {
		return {
			windowWidth: window.innerWidth,
			image_url: image_url,
			submited: false,
			modal_visible: false,

			asesores: [],
			asesores_filtrados: [],
			departamentos: [],
			provincias: [],
			provincias_filtradas: [],
			distritos: [],
			distritos_filtrados: [],

			operadores: ["MOVISTAR", "CLARO", "BITEL", "ENTEL", "OTROS"],

			frmDatosCliente: {
				modo: null,
				id: null,
				dni: null,
				apellido_paterno: null,
				apellido_materno: null,
				nombres: null,
				fecha_nacimiento: null,
				estado_civil: 0,
				genero: 0,
				agencia_id: 0,
				email: null,
				expediente: null,
				asesor_id: 0,
				agencia_id: 0,
				direccion: null,
				departamento_id: 0,
				provincia_id: 0,
				distrito_id: 0,
				referencia_direccion: null,
				telefonos: {
					t1: null,
					t2: null,
					t3: null,
					o1: 0,
					o2: 0,
					o3: 0,
					n1: null,
					n2: null,
					n3: null,
				},
				imagen_dni: null,
				nueva_imagen: false,
				notas: null,
			},
		};
	},
	mounted() {
		window.addEventListener("resize", () => {
			this.windowWidth = window.innerWidth;
		});

		this.ListarRecursos();
	},
	methods: {
		async ListarRecursos() {
			let self = this;
			return await axios
				.get(api_url + "/cli/gestion/listar_recursos")
				.then(function (response) {
					console.log(response.data);
					self.departamentos = response.data.departamentos;
					self.provincias = response.data.provincias;
					self.distritos = response.data.distritos;
					self.asesores = response.data.asesores;
				});
		},
		Resetear() {
			this.frmDatosCliente.id = 0;
			this.frmDatosCliente.modo = "NUEVO";
			this.frmDatosCliente.dni = null;
			this.frmDatosCliente.apellido_paterno = null;
			this.frmDatosCliente.apellido_materno = null;
			this.frmDatosCliente.nombres = null;
			this.frmDatosCliente.fecha_nacimiento = null;
			this.frmDatosCliente.estado_civil = 0;
			this.frmDatosCliente.genero = 0;
			this.frmDatosCliente.agencia_id = this.datos_sesion.agencia_id;
			this.frmDatosCliente.correo_electronico = null;
			this.frmDatosCliente.expediente = null;
			this.frmDatosCliente.asesor_id = 0;
			this.frmDatosCliente.notas = null;
			this.frmDatosCliente.direccion = null;
			this.frmDatosCliente.distrito_id = 0;
			this.frmDatosCliente.provincia_id = 0;
			this.frmDatosCliente.departamento_id = 0;
			this.frmDatosCliente.referencia_direccion = null;
			this.frmDatosCliente.imagen_dni = null;
			this.frmDatosCliente.nueva_imagen = false;
			this.frmDatosCliente.observaciones = null;
			this.frmDatosCliente.telefonos.t1 = null;
			this.frmDatosCliente.telefonos.t2 = null;
			this.frmDatosCliente.telefonos.t3 = null;
			this.frmDatosCliente.telefonos.n1 = null;
			this.frmDatosCliente.telefonos.n2 = null;
			this.frmDatosCliente.telefonos.n3 = null;
			this.frmDatosCliente.telefonos.o1 = 0;
			this.frmDatosCliente.telefonos.o2 = 0;
			this.frmDatosCliente.telefonos.o3 = 0;
		},
		Cerrar() {
			this.modal_visible = false;
		},
		FiltrarProvincias(e) {
			let departamento_id = e.target.value;

			if (!departamento_id == 0) {
				this.provincias_filtradas = this.provincias.filter(
					(item) => item.departamento_id == departamento_id
				);
			} else {
				this.provincias_filtradas = this.provincias;
			}

			this.frmDatosCliente.provincia_id = 0;
			this.frmDatosCliente.distrito_id = 0;
		},
		FiltrarDistritos(e) {
			let provincia_id = e.target.value;

			if (!provincia_id == 0) {
				this.distritos_filtrados = this.distritos.filter(
					(item) => item.provincia_id == provincia_id
				);
			} else {
				this.distritos_filtrados = this.distritos;
			}

			this.frmDatosCliente.distrito_id = 0;
		},
		FiltrarAsesores() {
			let agencia_id = this.frmDatosCliente.agencia_id;

			this.asesores_filtrados = this.asesores.filter(
				(item) => item.agencia_id == agencia_id
			);
		},
		AgregarFoto(e) {
			let img_id = e.target.id;

			// let previo = document.getElementById("contenido_" + indice + " img");
			// console.log(previo);
			// previo.parentNode.removeChild(previo);

			// let previo = document.getElementById("contenido");
			// if (previo) {
			// 	let imgElement = previo.querySelector("img");
			// 	console.log(imgElement);
			// 	if (imgElement) {
			// 		// imgElement.parentNode.removeChild(imgElement);
			// 	}
			// }

			this.frmDatosCliente.imagen_dni = e.target.files[0];
			this.frmDatosCliente.nueva_imagen = true;

			let reader = new FileReader();
			reader.readAsDataURL(e.target.files[0]); // leemos el archivo subido y se lo pasamos a nuestro fileReader
			reader.onload = function () {
				let preview = document.getElementById("contenido"),
					image = document.createElement("img");

				image.src = reader.result;
				image.id = "img";
				image.style.height = "100%";
				image.style.width = "100%";
				image.style.border = "1px solid #ffff";

				preview.append(image);
			};
		},
	},
};
</script>

<style lang="scss">
.mdlDatosCliente {
	width: 50%;
}

.subir {
	text-align: center;
	vertical-align: middle;
	width: 100% !important;
	height: 100% !important;

	background: #51515381;
	color: rgba(255, 255, 255, 0.575);
	border-radius: 5px;
	cursor: pointer;
}

.subir:hover {
	color: #fff;
	background: #515153a8;
}

.delete {
	position: fixed;

	right: 17%;
	z-index: 1000;
}

.foto-container {
	width: 70%;
	margin-left: 15%;
	height: 300px;
}

.foto-icon {
	margin-top: 15%;
	margin-bottom: 15%;
}

@media (max-width: 992px) {
	.mdlDatosCliente {
		width: 80%;
	}

	.foto-container {
		width: 100%;
		margin-left: 0%;
		height: 200px;
	}

	.delete {
		position: fixed;
		right: 20px;
	}
}

@media (max-width: 400px) {
	.mdlDatosCliente {
		width: 80%;
	}
}
</style>
