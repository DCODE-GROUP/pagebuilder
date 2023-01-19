/**
 * ================================================================
 *
 *	File: Vue3EventBus.js
 *	Description: Use this to provide Pub-Sub concept to
 *		existing components without the requirement of VueX
 *		for Vue 3 components that require cross-component
 *		talk.
 *
 *		It's used and passed through as a global variable
 *		on the main Vue app instance within /app.js
 *
 * 	Reference:
 *  [https://stackoverflow.com/questions/63471824/vue-js-3-event-bus#answer-64045893]
 *
 * ================================================================
 */

class Event {
    constructor() {
        this.events = {}
    }

    $on(eventName, fn) {
        this.events[eventName] = this.events[eventName] || []
        this.events[eventName].push(fn)
    }

    $off(eventName, fn) {
        if (this.events[eventName]) {
            for (let i = 0; i < this.events[eventName].length; i++) {
                if (this.events[eventName][i] === fn) {
                    this.events[eventName].splice(i, 1)
                    break
                }
            }
        }
    }

    $emit(eventName, data) {
        if (this.events[eventName]) {
            this.events[eventName].forEach(function (fn) {
                fn(data)
            })
        }
    }
}

export default new Event()
