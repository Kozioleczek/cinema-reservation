import { computed, ref, watch } from "vue";
import { Settings, MachineState } from "./useMachine.types";

function useMachine<T>(
  initialContext: T,
  initialStateName: string,
  machine: MachineState<T>[],
  settings?: Settings
) {
  const stateLocal = ref<MachineState<T> | null>(null);

  const contextLocal = ref<T>(initialContext);

  const state = computed(() => stateLocal.value);

  watch(state, (nextState) => {
    if (settings?.isDevMode) {
      console.log("[STATE UPDATE]", nextState);
    }
  });

  const context = computed(() => contextLocal.value);

  watch(
    context,
    (nextContext) => {
      if (settings?.isDevMode) {
        console.log("[CONTEXT UPDATE]", nextContext);
      }
    },
    { immediate: true }
  );

  const can = (eventName: string) =>
    state.value && state.value.on && state.value.on.hasOwnProperty(eventName);

  const is = (stateName: string) => state.value && state.value.id === stateName;

  const transition = (targetState: string) => {
    if (settings?.isDevMode) {
      console.log("[TRANSITION] from: ", state.value?.id, " to: ", targetState);
    }
    const findNextState = machine.find((state) => state.id === targetState);

    if (!findNextState) {
      console.warn(`Target state ${targetState} does not exist `);
      return;
    }

    stateLocal.value = { ...findNextState };

    // handle instant async
    if ("instant" in stateLocal.value && stateLocal.value.instant) {
      const instantAsyncAction = stateLocal.value.instant;

      instantAsyncAction
        .src(context.value as T, null)
        .then((response) => {
          const nextContext = instantAsyncAction.onDone.action(
            context.value as T,
            response
          );

          contextLocal.value = { ...(contextLocal.value as T), ...nextContext };

          if (instantAsyncAction.onDone.target) {
            transitionWithDelay(
              instantAsyncAction.onDone.target,
              instantAsyncAction.onDone.delay
            );
          }
        })
        .catch((error) => {
          const nextContext = instantAsyncAction.onFail.action(
            context.value as T,
            error
          );
          contextLocal.value = { ...(contextLocal.value as T), ...nextContext };

          if (instantAsyncAction.onFail.target) {
            transitionWithDelay(
              instantAsyncAction.onFail.target,
              instantAsyncAction.onFail.delay
            );
          }
        });
    }
  };

  // set initial state

  transition(initialStateName);

  const transitionWithDelay = (targetState: string, delay?: number) => {
    if (delay) {
      setTimeout(() => transition(targetState), delay);
    } else {
      transition(targetState);
    }
  };

  // payload is always object
  function send(eventName: string, payload?: any) {
    if (settings?.isDevMode) {
      console.log("[EVENT SEND]", eventName, payload);
    }
    if (!(state.value && state.value.on)) {
      console.warn(
        `Current state ${state.value?.id} does not have event ${eventName}`
      );
      return;
    }

    if (!can(eventName)) {
      console.warn(
        `You can not ${eventName} now! Current state is ${state.value?.id}`
      );
      return;
    }

    if (!state.value) {
      console.warn(`Current state is null`);
      return;
    }

    const currentEvent = state.value.on[eventName];

    if ("asyncAction" in currentEvent) {
      const currentAsyncAction = currentEvent.asyncAction;
      currentAsyncAction
        .src(context.value as T, payload)
        .then((response) => {
          const nextContext = currentAsyncAction.onDone.action(
            context.value as T,
            response
          );

          contextLocal.value = { ...(contextLocal.value as T), ...nextContext };

          if (currentAsyncAction.onDone.target) {
            transitionWithDelay(
              currentAsyncAction.onDone.target,
              currentAsyncAction.onDone.delay
            );
          }
        })
        .catch((error) => {
          const nextContext = currentAsyncAction.onFail.action(
            context.value as T,
            error
          );
          contextLocal.value = { ...(contextLocal.value as T), ...nextContext };

          if (currentAsyncAction.onFail.target) {
            transitionWithDelay(
              currentAsyncAction.onFail.target,
              currentAsyncAction.onFail.delay
            );
          }
        });
    }

    if ("action" in currentEvent && currentEvent.action) {
      const nextContext = currentEvent.action(context.value as T, payload);

      contextLocal.value = { ...(contextLocal.value as T), ...nextContext };
    }

    if ("actions" in currentEvent && currentEvent.actions) {
      for (let i = 0; i <= currentEvent.actions.length; i += 1) {
        const current = currentEvent.actions[i];

        const executeActionAndTransition = () => {
          if (current.action) {
            const nextContext = current.action(context.value as T, payload);

            contextLocal.value = {
              ...(contextLocal.value as T),
              ...nextContext,
            };
          }

          if ("target" in current && current.target) {
            transition(current.target);
          }
        };

        // First action with condition's callback => true is executed
        if (
          typeof current.condition === "function" &&
          current.condition(contextLocal.value as T, payload)
        ) {
          executeActionAndTransition();
          break;
        }

        if (typeof current.condition === "undefined") {
          executeActionAndTransition();
          break;
        }
      }
    }

    if ("target" in currentEvent && currentEvent.target) {
      transitionWithDelay(currentEvent.target, currentEvent.delay);
    }
  }

  return {
    state,
    context,
    is,
    can,
    send,
  };
}

export { useMachine };

export type { MachineState };
