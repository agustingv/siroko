import { useCartStore } from "../../stores/useCartStore"
import useFromStore from "../../hooks/useFromStore"
import Link from 'next/link'

export default function Header() {
    const cart = useFromStore(useCartStore, state => state.cart)

    return (
        <header className='bg-gray-900 text-white py-4 flex items-center justify-between h-14 sticky top-0 z-10'>
            <nav className='container mx-auto md:w-10/12 px-4 flex justify-between'>
                <span className='text-lg font-semibold'><Link href="/products">Test shopping cart</Link></span>
                <div className='relative'>
                </div>
            </nav>
        </header>
    )
}
