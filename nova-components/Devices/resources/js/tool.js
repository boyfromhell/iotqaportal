Nova.booting((Vue, router, store) => {
    router.addRoutes([
        {
            name: 'devices',
            path: '/devices',
            component: require('./components/Tool'),
        },
    ])
})
