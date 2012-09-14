#!/usr/bin/env ruby

for counter in 1..100
  if counter % 15 == 0 then
    puts "fizzbuzz"
  elsif counter % 5 == 0 then
    puts "buzz"
  elsif counter % 3 == 0 then
    puts "fizz"
  else
    puts counter
  end
end
