<template>
  <div class="home">
    <div class="row justify-content-start">
      <div class="col-6">
        <div class="card">
          <div class="card-header titulo-formulario">
            <h1>Cadastrar cotação frete</h1>
          </div>

          <form class="p-4">
            <div class="mb-3">
              <label for="transportadora_id" class="form-label"
                >Transportadora:</label
              >
              <select
                class="form-select"
                v-model="cotacao.transportadora_id"
                name="transportadora_id"
                id="transportadora_id"
              >
                <option
                  v-for="(transportadora, index) in transportadoras"
                  :key="index"
                  :value="transportadora.id"
                >
                  {{ transportadora.nome }}
                </option>
              </select>

              <div
                class="alert alert-danger mt-2"
                role="alert"
                v-if="
                  errorCadastroCotacao && errorCadastroCotacao.transportadora_id
                "
              >
                {{ errorCadastroCotacao.transportadora_id[0] }}
              </div>
            </div>
            <div class="mb-3">
              <label for="uf" class="form-label">UF:</label>
              <input
                type="text"
                class="form-control"
                id="uf"
                v-model="cotacao.uf"
              />
              <div
                class="alert alert-danger mt-2"
                role="alert"
                v-if="errorCadastroCotacao && errorCadastroCotacao.uf"
              >
                {{ errorCadastroCotacao.uf[0] }}
              </div>
            </div>
            <div class="mb-3">
              <label for="uf" class="form-label">Porcentual cotação (%):</label>
              <input
                type="number"
                class="form-control"
                id="percentual_cotacao"
                v-model="cotacao.percentual_cotacao"
              />
              <div
                class="alert alert-danger mt-2"
                role="alert"
                v-if="
                  errorCadastroCotacao &&
                  errorCadastroCotacao.percentual_cotacao
                "
              >
                {{ errorCadastroCotacao.percentual_cotacao[0] }}
              </div>
            </div>
            <div class="mb-3">
              <label for="uf" class="form-label">Valor extra (R$):</label>
              <input
                type="number"
                class="form-control"
                id="valor_extra"
                v-model="cotacao.valor_extra"
              />
              <div
                class="alert alert-danger mt-2"
                role="alert"
                v-if="errorCadastroCotacao && errorCadastroCotacao.valor_extra"
              >
                {{ errorCadastroCotacao.valor_extra[0] }}
              </div>
            </div>
            <button
              class="btn btn-primary"
              type="button"
              @click="cadastrarCotacaoFrete"
            >
              Salvar
            </button>
          </form>
        </div>
      </div>
      <div class="col-6">
        <div
          class="alert alert-danger mt-2 ml-4 mr-4"
          role="alert"
          v-if="UFS && UFS.length == 0"
        >
          Nenhuma cotação de frete cadastrada! Cadastre-se alguma para liberar o
          formulário de cotação.
        </div>

        <div class="card" v-else>
          <div class="card-header titulo-formulario">
            <h1>Cotar frete</h1>
          </div>

          <form class="p-4">
            <div class="mb-3">
              <label for="uf" class="form-label">UF:</label>
              <select class="form-select" v-model="cotar.uf" name="uf" id="uf">
                <option v-for="(uf, index) in UFS" :key="index" :value="uf.uf">
                  {{ uf.uf }}
                </option>
              </select>
              <div
                class="alert alert-danger mt-2"
                role="alert"
                v-if="errorCotar && errorCotar.uf"
              >
                {{ errorCotar.uf[0] }}
              </div>
            </div>

            <div class="mb-3">
              <label for="uf" class="form-label">Valor Pedido:</label>
              <input
                type="number"
                class="form-control"
                id="valor_pedido"
                v-model="cotar.valor_pedido"
              />
              <div
                class="alert alert-danger mt-2"
                role="alert"
                v-if="errorCotar && errorCotar.valor_pedido"
              >
                {{ errorCotar.valor_pedido[0] }}
              </div>
            </div>
            <button
              @click="simularCotacao"
              type="button"
              class="btn btn-primary"
              :disabled="carregamentoCotacoes"
            >
              Cotar
            </button>
          </form>

          <center class="p-4" v-if="carregamentoImpostos">
            <div class="spinner-border text-primary" role="status">
              <span class="visually-hidden">Loading...</span>
            </div>
          </center>

          <div
            class="sub-titulo p-4"
            v-else-if="!carregamentoImpostos && cotacoes.length > 0"
          >
            <div class="titulo">
              <h6>Melhores resultados</h6>
            </div>

            <div>
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th scope="col" class="text-center">Rank</th>
                    <th scope="col" class="text-center">Transportadora</th>
                    <th scope="col" class="text-center">Valor Cotação</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(cotacao, index) in cotacoes" :key="index">
                    <td class="text-center">{{ index + 1 }}</td>
                    <td class="text-center">{{ cotacao.transportadora_id }}</td>
                    <td class="text-center">
                      {{ formatPrecoCotacao(cotacao.valor_cotacao) }}
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12 tabela-imposto">
        <div class="card">
          <div class="card-header titulo-formulario">
            <h1>Impostos</h1>
          </div>

          <center class="p-4" v-if="carregamentoImpostos">
            <div class="spinner-border text-primary" role="status">
              <span class="visually-hidden">Loading...</span>
            </div>
          </center>

          <table class="table table-bordered" v-else>
            <thead>
              <tr>
                <th scope="col" class="text-center">ID</th>
                <th scope="col">UF</th>
                <th scope="col" class="text-center">Porcentual Frete</th>
                <th scope="col" class="text-center">Valor Taxa</th>
                <th scope="col" class="text-center">Transportadora</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(imposto, index) in impostos" :key="index">
                <td class="text-center">{{ imposto.id }}</td>
                <td>{{ imposto.uf }}</td>
                <td class="text-center">
                  {{ imposto.percentual_cotacao }}
                </td>
                <td class="text-center">
                  {{ imposto.valor_extra }}
                </td>
                <td class="text-center">
                  {{ imposto.transportadora_id }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "../../axios/api.js";

export default {
  name: "Home",
  data() {
    return {
      cotacao: {
        uf: null,
        percentual_cotacao: null,
        valor_extra: null,
        transportadora_id: null,
      },
      cotar: {
        uf: null,
        valor_pedido: null,
      },
      cotacoes: [],
      impostos: [],
      transportadoras: [],
      UFS: [],
      carregamentoImpostos: false,
      carregamentoCotacoes: false,
      errorCotar: {},
      errorCadastroCotacao: {},
    };
  },
  
  methods: {
    formatPrecoCotacao(valor) {
      if (!valor) return 0;
      return parseFloat(valor).toFixed(2);
    },

    async loadImpostos() {
      this.carregamentoImpostos = true;

      const getImpostos = await axios.get("/api/cotacao");

      if (getImpostos && getImpostos.status === 200) {
        this.impostos = getImpostos.data;
        this.carregamentoImpostos = false;
      }
    },

    async loadTransportadoras() {
      const getTransportadoras = await axios.get("/api/transportadoras");

      if (getTransportadoras && getTransportadoras.status === 200) {
        this.transportadoras = getTransportadoras.data;
      }
    },

    async loadUFS() {
      const getUFS = await axios.get("/api/cotacao/uf");

      if (getUFS && getUFS.status === 200) {
        this.UFS = getUFS.data;
      }
    },

    simularCotacao() {
      this.carregamentoCotacoes = true;

      axios
        .put("/api/cotacao", this.cotar)
        .then((response) => {
          if (response && response.status === 200) {
            this.cotacoes = response.data;
            this.carregamentoCotacoes = false;
            this.errorCotar = {};
          } else {
            this.$toast.open({
              message:
                "Não foi possivel realizar cotação! Verifique os campos.",
              type: "error",
            });
          }
        })
        .catch((error) => {
          if (error.response.data && error.response.data.errors) {
            this.errorCotar = error.response.data.errors;
            this.$toast.open({
              message:
                "Não foi possivel realizar cotação! Verifique os campos.",
              type: "error",
            });
          } else {
            this.$toast.open({
              message:
                "Não foi possivel realizar cotação! Verifique os campos.",
              type: "error",
            });
          }

          this.carregamentoCotacoes = false;
          this.cotacoes = [];
        });
    },

    cadastrarCotacaoFrete() {
      axios
        .post("/api/cotacao", this.cotacao)
        .then((response) => {
          if (response && response.status === 200) {
            this.errorCadastroCotacao = {};

            this.cotacao = {
              uf: null,
              percentual_cotacao: null,
              valor_extra: null,
              transportadora_id: null,
            };

            this.$toast.open({
              message: response.data.mensagem,
              type: "success",
            });

            this.setup();
          } else {
            this.$toast.open({
              message:
                "Não foi possivel realizar cotação! Verifique os campos.",
              type: "error",
            });
          }
        })
        .catch((error) => {
          if (error.response.data && error.response.data.errors) {
            this.errorCadastroCotacao = error.response.data.errors;
            this.$toast.open({
              message:
                "Não foi possivel realizar cotação! Verifique os campos.",
              type: "error",
            });
          } else {
            this.$toast.open({
              message: error.response.data.mensagem,
              type: "error",
            });
          }
        });
    },
    setup() {
      this.loadImpostos();
      this.loadTransportadoras();
      this.loadUFS();
    },
  },
  mounted() {
    this.setup();
  },
};
</script>


<style scoped>
.titulo-formulario {
  padding-top: 10px;
}
.titulo-formulario h1 {
  font-size: 18px;
}

.sub-titulo h6 {
  font-weight: bold;
  margin-bottom: 16px;
  font-size: 14px;
}

.tabela-imposto {
  margin-top: 2rem;
}
</style>