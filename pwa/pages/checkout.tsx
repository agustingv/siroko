import Header from "../components/ui/HeaderCheckout"
import Cart from "../components/minicart/CartCheckout"

export default function Home() {

    return (
        <>
            <Header />
            <main className='container mx-auto md:w-10/12 py-8 px-4'>
             <Cart />
            </main>
        </>
    )
}