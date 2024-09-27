import {
    trigger,
    transition,
    state,
    animate,
    style,
    keyframes,
  } from '@angular/animations';
  
  export const toolbarAnimation = trigger('expandCollapse', [
        state(
            'open',
            style({
            transform: `translate3d(0,0, 0)`,
            })
        ),
        state(
            'reExpand',
            style({
              transform: `translate3d(0,0, 0)`,
            })
          ),
          transition('open => reExpand', [

            animate(
              '0.5s ease-out',
              keyframes([
                style({
                  height: '0px',
                  overflow:'hidden'
                }),
                style({
                  height: '12px',
                  overflow:'hidden'
                }),
                style({
                  height: '24px',
                  overflow:'hidden'
                }),
                style({
                  height: '36px',
                  overflow:'hidden'
                }),
                style({
                  height: '48px',
                  overflow:'hidden'
                }),
                style({
                  height: '72px',
                  overflow:'hidden'
                }),
              ])
            ),animate('400ms ease-in-out')]),
  ]);
  