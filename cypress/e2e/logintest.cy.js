describe('Open page', () => {
  it('passes', () => {
    cy.visit('http://localhost:3000')
  })
})


context('Actions', () => {
    beforeEach(() => {
            cy.visit('http://localhost:3000')
            cy.get('input[name="email"]').type('superadmin@gmail.com') // type email
            cy.get('input[name="password"]').type('password') // type password
            // with multiple true clicking submit button
            // cy.get('button[type="submit"]').click({ multiple: false })
            cy.get('button[type="submit"]').first().click() // click submit button
            // check if page got redirected to dashboard
            cy.url().should('include', '/dashboard')
    })

        // login test on page
    describe('Login', () => {
        it('logs in', () => {
            cy.visit('http://localhost:3000')
            cy.get('input[name="email"]').type('superadmin@gmail.com') // type email
            cy.get('input[name="password"]').type('password') // type password
            // with multiple true clicking submit button
            // cy.get('button[type="submit"]').click({ multiple: false })
            cy.get('button[type="submit"]').first().click() // click submit button
            // check if page got redirected to dashboard
            cy.url().should('include', '/dashboard')
        })
    })

    //check if admin can see user-management
    describe('User Management', () => {
        it('can see user management', () => {
            cy.visit('http://localhost:3000/user-management/user')
            cy.url().should('include', '/user-management')
        })
    })

    // check the next page of user-management/user
    describe('User Management', () => {
        it('can see extra pages', () => {
            cy.visit('http://localhost:3000/user-management/user')
            // see user-management
            cy.url().should('include', '/user-management')
            // click next page
            cy.get('a[rel="next"]').first().click()
            // see user name (Ian)
            cy.contains('Ian')
        })
    })


    //add user test on user-management/user
    describe('Add user', () => {
        it('adds user', () => {
            cy.visit('http://localhost:3000/user-management/user/create')
            cy.get('input[name="name"]').type('Ian') // type name
            cy.get('input[name="email"]').type('fiandra18@gmail.com') // type email
            cy.get('input[name="password"]').type('password') // type password
            // press submit button on card footer with the text Submit
            cy.contains('Submit').click()
            // check if page got redirected to user-management/user
            cy.url().should('include', '/user-management/user')
            cy.visit('http://localhost:3000/user-management/user')
            // laravel style pagination button
            cy.get('a[rel="next"]').first().click()

            // check if user is added
            cy.get('td').contains('Ian')
        })
    })

    describe('Add empty user', () => {
        it('adds empty user', () => {
            cy.visit('http://localhost:3000/user-management/user/create')
            cy.get('input[name="name"]').type(' ') // type name
            cy.get('input[name="email"]').type(' ') // type email
            cy.get('input[name="password"]').type(' ') // type password
            // press submit button on card footer with the text Submit
            cy.contains('Submit').click()
            // see error message
            cy.contains('The name field is required.')
        })
    })

    // check image-management/image
    describe('Image', () => {
        it('checks image', () => {
            cy.visit('http://localhost:3000/image-management/image')
            // check if page got redirected to image-management/image
            cy.url().should('include', '/image-management/image')
        })
    })

    // try to upload on image-management/image
    describe('Upload image', () => {
        it('uploads image', () => {
            cy.visit('http://localhost:3000/image-management/image')

            cy.url().should('include', '/image-management/image')

            cy.visit('http://localhost:3000/image-management/create')
            // check if page got redirected to image-management/image/create
            cy.url().should('include', '/image-management/create')
            // enter file name
            cy.get('input[name="name"]').type('test')

            cy.get('input[name="file_name"]').then(subject => {
                cy.fixture('test.png', 'base64')
                    .then(Cypress.Blob.base64StringToBlob)
                    .then(blob => {
                        const el = subject[0]
                        const testFile = new File([blob], 'test.png', { type: 'image/png' })
                        const dataTransfer = new DataTransfer()
                        dataTransfer.items.add(testFile)
                        el.files = dataTransfer.files
                        cy.wrap(subject).trigger('change', { force: true })
                    })
            })
            // press submit button on card footer with the text Submit
            cy.contains('Submit').click()
            // check if page got redirected to image-management/image
            cy.url().should('include', '/image-management/image')

            // check if test file is present on image-management/image

            cy.get('td').contains('test')

            // delete test file using button labelled Delete
            cy.contains('Delete').click()

        })
    })

})



