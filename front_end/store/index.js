import Vue from 'vue'
import Vuex from 'vuex'
import axios from '../config/axios'

Vue.use(Vuex)

const store = () => new Vuex.Store({

  state: {
    loading: true,
    users: null,
    oneself: {},
    permissions: null,
    menus: null,
    advisories: null,
    channels: null,
    doctors: null,
    diseases: null
  },
  mutations: {
    getUsers (state, users) {
      state.users = users
    },
    getOneself (state, oneself) {
      state.oneself = oneself
    },
    getPermissions (state, permissions) {
      state.permissions = permissions
    },
    getMenu (state, menus) {
      state.menus = menus
    },
    getAdvisories (state, advisories) {
      state.advisories = advisories
    },
    getChannels (state, channels) {
      state.channels = channels
    },
    getDoctors (state, doctors) {
      state.doctors = doctors
    },
    getDiseases (state, diseases) {
      state.diseases = []
      for (let disease in diseases) {
        state.diseases.push(diseases[disease])
      }
    }
  },
  actions: {
    getUsers ({commit}, callback = () => {}) {
      axios.get('/users')
        .then(res => {
          commit('getUsers', res.users)
          callback()
        })
    },
    getOneself ({commit}) {
      axios.get('/users/0')
        .then(res => {
          commit('getOneself', res.user)
        })
    },
    getPermissions ({commit}, uid) {
      axios.get(`/permissions/${uid}`)
        .then(res => {
          commit('getPermissions', res.permissions)
        })
    },
    getMenu ({commit}, callback = () => {}) {
      axios.get('/menus')
        .then(res => {
          commit('getMenu', res.menuses)
          callback()
        })
    },
    getAdvisories ({commit}) {
      axios.get('/management/advisories')
        .then(res => {
          commit('getAdvisories', res.advisories)
        })
    },
    getChannels ({commit}) {
      axios.get('/management/channels')
        .then(res => {
          commit('getChannels', res.channels)
        })
    },
    getDoctors ({commit}) {
      axios.get('/management/doctors')
        .then(res => {
          commit('getDoctors', res.doctors)
        })
    },
    getDiseases ({commit}) {
      axios.get('/management/diseases')
        .then(res => {
          commit('getDiseases', res.diseases)
        })
    }
  }
})

export default store
