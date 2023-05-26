<template>
	<!-- The Modal -->
	<div>
		<Dialog
			class="mdlEditarPermisos"
			:visible="modal_visible"
			:modal="true"
			@update:visible="Cerrar()"
			:header="'EDITAR PERMISOS'"
		>
			<h5 class="card-title">DATOS DE USUARIO</h5>
			<div class="modal-body">
				<div class="row justify-content-center">
					<div class="form-group col-md-5 col-7">
						<div class="input-group">
							<span class="input-group-text">USUARIO</span>
							<input
								type="text"
								class="form-control"
								disabled
								:value="frmDatosUsuario.colaborador"
							/>
						</div>
					</div>
					<div class="form-group col-md-3 col-5">
						<div class="input-group">
							<span class="input-group-text">AGENCIA</span>
							<input
								type="text"
								class="form-control center"
								disabled
								:value="frmDatosUsuario.agencia"
							/>
						</div>
					</div>
					<div class="form-group col-md-4">
						<div class="input-group">
							<span class="input-group-text">CARGO</span>
							<input
								type="text"
								class="form-control"
								disabled
								:value="frmDatosUsuario.cargo"
							/>
						</div>
					</div>
				</div>
				<br />
				<div class="row justify-content-center">
					<div class="field-checkbox col-md-2 col-2 mb-2">
						<Checkbox
							id="rdbCopiar"
							v-model="panel_copiar"
							:binary="true"
							name="Copiar"
						/>
						<label class="ml-3" for="rdbCopiar">Copiar</label>
					</div>
				</div>
				<div class="row justify-content-center" v-if="panel_copiar">
					<div class="form-group col-md-6 col-10">
						<div class="input-group">
							<span class="input-group-text">De usuario</span>
							<select
								class="form-select text-center"
								v-model="agencia_seleccionada"
								@change="FiltrarUsuarios"
							>
								<option :value="0" selected disabled>Seleccione...</option>
								<option
									v-for="(item, index) in agencias"
									:key="index"
									:value="item.id"
								>
									{{ item.agencia }}
								</option>
							</select>
							<select class="form-select center" v-model="usuario_seleccionado">
								<option :value="0" selected disabled>Seleccione...</option>
								<option
									v-for="(item, index) in usuarios_filtrados"
									:key="index"
									:value="item.id"
								>
									{{ item.usuario }}
								</option>
							</select>
						</div>
					</div>
					<div class="form-group col-md-1 ml-1 col-2" style="float: left">
						<button
							type="button"
							class="btn btn-main-1 btn-icon-split"
							@click="Copiar"
						>
							<i class="pi pi-copy"></i>
							<span class="text">COPIAR</span>
						</button>
					</div>
				</div>
			</div>
			<h5 class="card-title">PERMISOS DISPONIBLES</h5>
			<div class="modal-body">
				<div class="row justify-content-md-center mb-2 col-12">
					<div class="col-md-4 col-6">
						<div class="input-group">
							<span class="input-group-text">MÓDULO</span>
							<select
								class="form-select text-center"
								v-model="filtros_disponibles['modulo'].value"
							>
								<option :value="null" selected>TODOS</option>
								<option
									v-for="(item, index) in modulos_disponibles"
									:key="index"
								>
									{{ item.modulo }}
								</option>
							</select>
						</div>
					</div>

					<div class="col-md-5 col-6 mb-1">
						<div class="input-group">
							<span class="input-group-text">
								<i class="pi pi-search"></i>
							</span>
							<input
								v-model="filtros_disponibles['global'].value"
								class="form-control mayus"
								type="text"
								placeholder="Buscar..."
								autocomplete="off"
								spellcheck="false"
							/>
						</div>
					</div>
				</div>

				<DataTable
					:value="permisos_disponibles"
					scrollable
					scrollHeight="300px"
					scrollDirection="both"
					:filters="filtros_disponibles"
					:globalFilterFields="['modulo', 'submodulo']"
					:paginator="true"
					:rows="20"
					paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport"
					currentPageReportTemplate="Mostrando {first} a {last} de {totalRecords} registro(s)"
				>
					<Column class="align-center" field="editar" style="width: 70px">
						<template #header>
							<input type="checkbox" v-model="todos_disponibles" />
						</template>
						<template #body="{ data }">
							<input
								type="checkbox"
								:value="data"
								v-model="seleccionados_disponibles.permisos"
							/>
						</template>
					</Column>
					<Column field="modulo" header="MÓDULO" style="width: 200px">
						<template #body="{ data }">
							{{ data.modulo }}
						</template>
					</Column>
					<Column field="submodulo" header="SUBMÓDULO" style="width: 200px">
						<template #body="{ data }">
							{{ data.submodulo }}
						</template>
					</Column>
				</DataTable>
				<div class="col-md-2 text-center mt-2">
					<button
						type="button"
						class="btn btn-main-1 btn-icon-split"
						@click="Asignar"
						:disabled="seleccionados_disponibles.permisos.length == 0"
					>
						<i class="pi pi-check"></i>
						<span class="text">ASIGNAR</span>
					</button>
				</div>
			</div>

			<h5 class="card-title">PERMISOS ACTUALES</h5>

			<div class="modal-body">
				<div class="row justify-content-md-center mb-2 col-12">
					<div class="col-md-4 col-6">
						<div class="input-group">
							<span class="input-group-text">MÓDULO</span>
							<select
								class="form-select text-center"
								v-model="filtros_actuales['modulo'].value"
							>
								<option :value="null" selected>TODOS</option>
								<option v-for="(item, index) in modulos_actuales" :key="index">
									{{ item.modulo }}
								</option>
							</select>
						</div>
					</div>

					<div class="col-md-4 col-6">
						<div class="input-group">
							<span class="input-group-text">
								<i class="pi pi-search"></i>
							</span>
							<input
								v-model="filtros_actuales['global'].value"
								class="form-control mayus"
								type="text"
								placeholder="Buscar..."
								autocomplete="off"
								spellcheck="false"
							/>
						</div>
					</div>
				</div>

				<DataTable
					:value="permisos_actuales"
					scrollable
					scrollHeight="300px"
					scrollDirection="both"
					:filters="filtros_actuales"
					:globalFilterFields="['modulo', 'submodulo']"
					:paginator="true"
					:rows="20"
					paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport"
					currentPageReportTemplate="Mostrando {first} a {last} de {totalRecords} registro(s)"
				>
					<Column class="align-center" header="ELIMINAR" style="width: 70px">
						<template #body="{ data }">
							<button
								class="btn btn-danger btn-sm rounded-pill"
								@click="Eliminar(data.id)"
							>
								<i class="pi pi-trash"></i>
							</button>
						</template>
					</Column>

					<Column field="modulo" header="MÓDULO" style="width: 200px">
						<template #body="{ data }">
							{{ data.modulo }}
						</template>
					</Column>
					<Column field="submodulo" header="SUBMÓDULO" style="width: 200px">
						<template #body="{ data }">
							{{ data.submodulo }}
						</template>
					</Column>
				</DataTable>
				<div class="text-center col-md-2 mt-2">
					<button
						type="button"
						class="btn btn-danger btn-icon-split"
						@click="EliminarTodo"
					>
						<i class="pi pi-trash"></i>
						<span class="text">ELIMINAR TODOS</span>
					</button>
				</div>
			</div>
		</Dialog>
	</div>
</template>

<script>
import Dialog from "primevue/dialog";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import Row from "primevue/row";
import Checkbox from "primevue/checkbox";
import { FilterMatchMode } from "primevue/api";

const api_url = import.meta.env.VITE_API_URL;
export default {
	props: { agencias: Array, cargos: Array, usuarios: Array },
	components: {
		Dialog,

		DataTable,
		Column,
		Row,
		Checkbox,
	},
	data() {
		return {
			modal_visible: false,

			frmDatosUsuario: {
				id: null,
				colaborador: null,
				agencia: null,
				cargo: null,
			},

			filtros_disponibles: {},
			filtros_actuales: {},

			panel_copiar: false,
			agencia_seleccionada: 0,
			usuarios_filtrados: [],
			usuario_seleccionado: 0,

			permisos_disponibles: [],
			modulos_disponibles: [],
			permisos_actuales: [],
			modulos_actuales: [],

			todos_disponibles: false,
			seleccionados_disponibles: { permisos: [] },
		};
	},
	watch: {
		todos_disponibles(value) {
			if (value) {
				this.seleccionados_disponibles.permisos = this.permisos_disponibles;
			} else {
				this.seleccionados_disponibles.permisos = [];
			}
		},
	},
	created() {
		this.filtros_disponibles = {
			global: { value: null, matchMode: FilterMatchMode.CONTAINS },
			modulo: { value: null, matchMode: FilterMatchMode.CONTAINS },
			submodulo: { value: null, matchMode: FilterMatchMode.CONTAINS },
		};
		this.filtros_actuales = {
			global: { value: null, matchMode: FilterMatchMode.CONTAINS },
			modulo: { value: null, matchMode: FilterMatchMode.CONTAINS },
			submodulo: { value: null, matchMode: FilterMatchMode.CONTAINS },
		};
	},
	methods: {
		async ListarPermisos() {
			let self = this;
			return await axios
				.get(
					api_url + "/usu/permisos/listar_permisos/" + self.frmDatosUsuario.id
				)
				.then(function (response) {
					self.permisos_actuales = response.data.permisos_actuales;
					self.modulos_actuales = response.data.modulos_actuales;
					self.permisos_disponibles = response.data.permisos_disponibles;
					self.modulos_disponibles = response.data.modulos_disponibles;
				});
		},
		Cerrar() {
			this.modal_visible = false;
		},
		FiltrarUsuarios() {
			this.usuarios_filtrados = this.usuarios.filter(
				(item) => item.agencia_id == this.agencia_seleccionada
			);
		},
		async Copiar() {
			let self = this;
			let data = new FormData();

			data.append("modulo", this.modulo);
			data.append("frmDatosUsuario", JSON.stringify(this.frmDatosUsuario));

			if (this.usuario_seleccionado == 0) {
				this.$swal.fire({
					icon: "error",
					title: "¡Ups!",
					text: "Seleccione el usuario.",
				});
				return false;
			} else {
				data.append("usuario_seleccionado", this.usuario_seleccionado);
			}

			this.$swal
				.fire({
					title: "¿Desea continuar?",
					confirmButtonText: "Si",
					showCancelButton: true,
					cancelButtonText: "No",
					allowOutsideClick: false,
					backdrop: true,
				})
				.then((result) => {
					if (result.isConfirmed) {
						self.$swal.fire({
							title: "Registrando...",
							showConfirmButton: false,
							allowOutsideClick: false,
							willOpen: async () => {
								self.$swal.showLoading();

								return await axios
									.post(api_url + "/usu/permisos/copiar", data)
									.then(async (response) => {
										self.panel_copiar = null;
										self.seleccionados_disponibles.permisos = [];

										await self.ListarPermisos();

										return self.$swal.fire({
											icon: "success",
											title: "¡ÉXITO!",
											timer: 1200,
											showConfirmButton: false,
										});
									})
									.catch((error) => {
										self.$swal.showValidationMessage(
											`Ha ocurrido un error, comunicar a TI: ${error}`
										);
									});
							},
						});
					}
				});
		},

		async Asignar() {
			let self = this;
			this.$swal
				.fire({
					title: "¿Desea continuar?",
					confirmButtonText: "Si",
					showCancelButton: true,
					cancelButtonText: "No",
					allowOutsideClick: false,
					backdrop: true,
				})
				.then((result) => {
					if (result.isConfirmed) {
						self.$swal.fire({
							title: "Registrando...",
							showConfirmButton: false,
							allowOutsideClick: false,
							willOpen: async () => {
								self.$swal.showLoading();

								let data = new FormData();
								data.append(
									"frmDatosUsuario",
									JSON.stringify(this.frmDatosUsuario)
								);
								data.append(
									"seleccionados_disponibles",
									JSON.stringify(this.seleccionados_disponibles)
								);
								return await axios
									.post(api_url + "/usu/permisos/asignar", data)
									.then(async (response) => {
										self.seleccionados_disponibles.permisos = [];
										await self.ListarPermisos();

										return self.$swal.fire({
											icon: "success",
											title: "¡ÉXITO!",
											timer: 1200,
											showConfirmButton: false,
										});
									})
									.catch((error) => {
										self.$swal.showValidationMessage(
											`Ha ocurrido un error, comunicar a TI: ${error}`
										);
									});
							},
						});
					}
				});
		},

		async Eliminar(permiso_id) {
			let self = this;
			this.$swal
				.fire({
					title: "¿Desea eliminar este permiso?",
					confirmButtonText: "Si",
					showCancelButton: true,
					cancelButtonText: "No",
					allowOutsideClick: false,
					backdrop: true,
				})
				.then((result) => {
					if (result.isConfirmed) {
						self.$swal.fire({
							title: "Eliminar...",
							showConfirmButton: false,
							allowOutsideClick: false,
							willOpen: async () => {
								self.$swal.showLoading();

								return await axios
									.delete(api_url + "/usu/permisos/eliminar/" + permiso_id)
									.then(async (response) => {
										self.seleccionados_disponibles.permisos = [];
										await self.ListarPermisos();

										return self.$swal.fire({
											icon: "success",
											title: "¡ÉXITO!",
											timer: 1200,
											showConfirmButton: false,
										});
									})
									.catch((error) => {
										self.$swal.showValidationMessage(
											`Ha ocurrido un error, comunicar a TI: ${error}`
										);
									});
							},
						});
					}
				});
		},
		async EliminarTodo() {
			let self = this;
			this.$swal
				.fire({
					title: "¿Desea eliminar todos los permisos?",
					confirmButtonText: "Si",
					showCancelButton: true,
					cancelButtonText: "No",
					allowOutsideClick: false,
					backdrop: true,
				})
				.then((result) => {
					if (result.isConfirmed) {
						self.$swal.fire({
							title: "Eliminar...",
							showConfirmButton: false,
							allowOutsideClick: false,
							willOpen: async () => {
								self.$swal.showLoading();

								return await axios
									.delete(
										api_url +
											"/usu/permisos/eliminar_todos/" +
											self.frmDatosUsuario.id
									)
									.then(async (response) => {
										self.seleccionados_disponibles.permisos = [];
										await self.ListarPermisos();

										return self.$swal.fire({
											icon: "success",
											title: "¡ÉXITO!",
											timer: 1200,
											showConfirmButton: false,
										});
									})
									.catch((error) => {
										self.$swal.showValidationMessage(
											`Ha ocurrido un error, comunicar a TI: ${error}`
										);
									});
							},
						});
					}
				});
		},
	},
};
</script>

<style>
</style>
