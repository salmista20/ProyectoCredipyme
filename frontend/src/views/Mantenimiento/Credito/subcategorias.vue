<template>
	<div>
		<HeaderNav />
		<div class="main-content">
			<div class="layout-px-spacing dash_1 slot-mantenimiento-subcategorias">
				<div class="row layout-top-spacing">
					<div class="layout-spacing">
						<div class="card component-card_1">
							<HeaderClose
								:title="'LISTA DE SUBCATEGORIAS'"
								:area="'MANTENIMIENTO'"
							></HeaderClose>
							<h5 class="card-title">LISTA DE RESULTADOS</h5>
							<div class="card-body">
								<div class="row mb-2 col-12">
									<div class="col-md-5 col-9">
										<div class="input-group">
											<span class="input-group-text">
												<i class="pi pi-search"></i>
											</span>
											<input
												v-model="filters['global'].value"
												class="form-control mayus"
												type="text"
												placeholder="Buscar..."
												autocomplete="off"
												spellcheck="false"
											/>
										</div>
									</div>

									<div class="col-md-3 col-3">
										<button
											type="button"
											class="btn btn-main-1 btn-icon-split"
											@click="Nuevo"
										>
											<i class="pi pi-plus"></i>
											<span class="text">NUEVA</span>
										</button>
									</div>
								</div>
								<DataTable
									:value="subcategorias"
									:scrollable="true"
									scrollHeight="450px"
									scrollDirection="both"
									:filters="filters"
									:globalFilterFields="['subcategoria','descripcion']"
									:paginator="false"
									currentPageReportTemplate="Mostrando {first} a {last} de {totalRecords} registro(s)"
								>
								
								<Column
										class="align-center"
										field="editar"
										header="EDITAR"
										style="width: 50px !important"
									>
										<template #body="{ data }">
											<div class="btn-group" role="group">
												<button
													class="btn btn-main-1 btn-sm"
													@click="Editar(data)"
												>
													<i class="pi pi-pencil"></i>
												</button>
											</div>
										</template>
									</Column>
									<Column
										class="align-center"
										field="subcategoria"
										header="SUBCATEGORIA"
										style="width: 200px !important"
									>
										<template #body="{ data }">
											{{ data.subcategoria }}
										</template>
									</Column>
										<Column
										class="align-center"
										field="categoria"
										header="CATEGORIA"
										style="width: 200px !important"
									>
										<template #body="{ data }">
											{{ data.categoria }}
										</template>						
									</Column>
									
									<Column
									field="descripcion"
									header="DESCRIPCIÓN"
									style="width: 200px !important"
								>
									<template #body="{ data }">
									{{ data.descripcion }}
									</template>
								</Column>
									<Column
										field="habilitado"
										header="HABILITADO"
										style="width: 50px !important"
									>
										<template #body="{ data }">
											{{ data.habilitado == 1 ? "SI" : "NO" }}
										</template>
									</Column>
								</DataTable>
							</div>
						</div>
					</div>
				</div>
			</div>

				<Dialog
				class="mdlDatosSubcategoria"
				:visible="modal_visible"
				:modal="true"
				@update:visible="Cerrar"
				:header="title_modal"
			>
				<div class="row">
					<div class="form-group">
					<label class="label-title">SUBCATEGORÍA</label>
					<input
						class="form-control"
						v-model="frmDatosSubcategoria.subcategoria"
					/>
					</div>
					<div class="form-group">
					<label class="label-title">DESCRIPCIÓN</label>
					<textarea
						class="form-control"
						v-model="frmDatosSubcategoria.descripcion"
					></textarea>
					</div>
					<div class="form-group">
						<label class="label-title">CATEGORÍA</label>
						<select class="form-control" v-model="frmDatosSubcategoria.categoria_id">
							<option value="">Seleccione una categoría</option>
							<option v-for="categoria in categorias" :key="categoria.id" :value="categoria.id">{{ categoria.nombre }}</option>
						</select>
					</div>

					<div class="form-group" v-if="frmDatosSubcategoria.modo == 'EDITAR'">
					<label class = "label-title">HABILITADO</label>	
					<div class="form-check">
					<input
						class="form-check-input"
						type="checkbox"
						v-model="frmDatosSubcategoria.habilitado"
						id="chbHabilitado"
						/>
						<label class="form-check-label" for="chbHabilitado">habilitado</label>
						</div>
					</div>
				</div>
				<hr />
				<div class="text-right">
					<button
					type="button"
					class="btn btn-main-1 btn-icon-split"
					@click="Guardar"
					>
					<i class="pi pi-save"></i> 
					<span class="text">GUARDAR</span>
					</button>
				</div>
			</Dialog>
		</div>
	</div>
</template>

<script>
import { useStorage } from "vue3-storage";
import HeaderNav from "@/components/HeaderNav.vue";
import HeaderClose from "@/components/HeaderClose.vue";

import DataTable from "primevue/datatable";
import Column from "primevue/column";

import Dialog from "primevue/dialog";
import Button from "primevue/button";
import 'primeicons/primeicons.css';

import { FilterMatchMode } from "primevue/api";

import { useVuelidate } from "@vuelidate/core";
import { required } from "@vuelidate/validators";

const api_url = import.meta.env.VITE_API_URL;
export default {
	setup() {
		return { v$: useVuelidate(), storage: useStorage() };
	},
	components: {
		HeaderNav,
		HeaderClose,

		DataTable,
		Column,
		Dialog,
		Button,
	},
	data() {
		return {
			subcategorias: [],
			filters: {},

			title_modal: null,
			modal_visible: false,
			submited: false,

			frmDatosSubcategoria: {
				modo: null,
				id: null,
				subcategoria: null,
				descripcion: null,
				habilitado: false,
			},
		};
	},
	validations: {
		frmDatosSubcategoria: {
			subcategoria: { required },
		},
	},
	created() {
		this.filters = {
			global: { value: null, matchMode: FilterMatchMode.CONTAINS },
			subcategoria: { value: null, matchMode: FilterMatchMode.CONTAINS },
		};
	},
	mounted() {
		this.ListarRecursos();
	},

	methods: {
		async ListarRecursos() {
			let self = this;
			return await axios
				.get(api_url + "/man/cre/subcategorias/listar_recursos")
				.then(function (response) {
					self.subcategorias = response.data.subcategorias;
				});
		},
		Cerrar() {
			this.modal_visible = false;
		},
		Editar(item) {
			this.title_modal = "EDITAR SUBCATEGORIA";
			this.frmDatosSubcategoria.modo = "EDITAR";

			this.frmDatosSubcategoria.id = item.id;
			this.frmDatosSubcategoria.subcategoria= item.subcategoria;
			this.frmDatosSubcategoria.habilitado = item.habilitado;

			this.modal_visible = true;
		},
		Nuevo() {
			this.Resetear();
			this.frmDatosSubcategoria.modo = "NUEVO";
			this.title_modal = "NUEVA SUBCATEGORIA";
			this.modal_visible = true;
		},
		Resetear() {
			this.submited = false;

			this.frmDatosSubcategoria.id = null;
			this.frmDatosSubcategoria.subcategoria = null;
			this.frmDatosSubcategoria.habilitado = false;
		},
		async Guardar() {
			let self = this;
			this.submited = true;
			if (this.v$.frmDatosSubcategoria.$invalid == true) {
				self.$swal.fire({
					icon: "error",
					title: "¡Ups!",
					text: "Hay uno o más campos vacíos, verifique.",
				});
				return false;
			}

			let data = new FormData();
			data.append("frmDatosSubcategoria", JSON.stringify(this.frmDatosSubcategoria));

			await axios
				.post(api_url + "/man/cre/subcategorias/verificar", data)
				.then(function (response) {
					let resultado = response.data.resultado;
					if (resultado == "EXISTE") {
						self.$swal.fire({
							icon: "warning",
							title: "¡Ups!",
							text: "Esta información ya está registrada, intente nuevamente.",
						});
						return false;
					} else if (resultado == "NO_EXISTE") {
						self.$swal
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
										title: "REGISTRANDO",
										showConfirmButton: false,
										allowOutsideClick: false,
										willOpen: async () => {
											self.$swal.showLoading();

											return await axios
												.post(api_url + "/man/cre/subcategorias/guardar", data)
												.then((response) => {
													self.submited = false;
													self.ListarRecursos();
													self.Cerrar();

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
					}
				});
		},
	},
};
</script>

<style lang="scss">
.slot-mantenimiento-subcategorias {
	width: 50% !important;
	margin-left: 25% !important;
}

.mdlDatosSubcategoria {
	width: 30%;
}

@media (max-width: 992px) {
	.slot-mantenimiento-subcategorias {
		width: 80% !important;
		margin-left: 10% !important;
	}

	.mdlDatosSubcategoria {
		width: 40%;
	}
}

@media (max-width: 400px) {
	.slot-mantenimiento-subcategorias {
		width: 98% !important;
		margin-left: 1% !important;
	}

	.mdlDatosSubcategoria {
		width: 80%;
	}
}
</style>
