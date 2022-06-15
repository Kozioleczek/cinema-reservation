export type Action<T> = (context: T, data: any) => any;

export interface AsyncActionHandlers<T> {
  target?: string;
  delay?: number;
  action: Action<T>;
}

export interface AsyncAction<T> {
  src: (context: T, payload: any) => Promise<any>;
  onDone: AsyncActionHandlers<T>;
  onFail: AsyncActionHandlers<T>;
}

export interface Actions<T> {
  condition?: (context: T, payload: any) => boolean;
  target?: string;
  action?: Action<T>;
}

export interface Event<T> {
  target?: string;
  delay?: number;
  action?: Action<T>;
}

export interface EventWithMultipleActions<T> {
  actions?: Actions<T>[];
}

export interface EventAsync<T> {
  asyncAction: AsyncAction<T>;
}

export interface MachineState<T> {
  id: string;
  component?: any;
  instant?: AsyncAction<T>;
  on: {
    [key: string]: Event<T> | EventAsync<T> | EventWithMultipleActions<T>;
  };
}

export interface Settings {
  isDevMode: boolean;
}
